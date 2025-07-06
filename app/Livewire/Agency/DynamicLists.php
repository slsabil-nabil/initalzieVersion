<?php

namespace App\Livewire\Agency;

use Livewire\Component;
use App\Models\DynamicList;
use App\Models\DynamicListItem;
use App\Models\DynamicListItemSub;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

#[Layout('layouts.agency')]
class DynamicLists extends Component
{
    // General Properties
    public string $newListName = '';
    public array $itemLabel = [];
    public array $subItemLabel = [];
    public array $expandedLists = [];

    // Sub-item Editing Properties
    public ?int $editingSubItemId = null;
    public string $editingSubItemLabel = '';

    // Cloning State
    public bool $isCloning = false;
    public array $clonedListsCache = [];

    /**
     * Get lists available for the agency
     */
    public function getListsProperty(): EloquentCollection
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return DynamicList::with(['items.subItems'])
                ->system()
                ->orderBy('name')
                ->get();
        }

        $agencyLists = DynamicList::with(['items.subItems'])
            ->agency($user->agency_id)
            ->get();

        $copiedOriginalIds = $agencyLists->whereNotNull('original_id')
            ->pluck('original_id')
            ->toArray();

        $systemLists = DynamicList::with(['items.subItems'])
            ->system()
            ->whereNotIn('id', $copiedOriginalIds)
            ->get();

        return $agencyLists->merge($systemLists)
            ->sortBy('name')
            ->values();
    }

    /**
     * Toggle list expansion state
     */
    public function toggleExpand(int $listId): void
    {
        if (in_array($listId, $this->expandedLists)) {
            $this->expandedLists = array_diff($this->expandedLists, [$listId]);
            return;
        }

        $this->expandedLists[] = $listId;
    }

    /**
     * Add new sub-item
     */
    public function addSubItem(int $itemId): void
    {
        $this->validate([
            "subItemLabel.$itemId" => 'required|string|max:255',
        ]);

        $item = DynamicListItem::with(['list', 'subItems'])->findOrFail($itemId);
        $user = Auth::user();

        if (!$item->list->isEditableBy($user)) {
            if ($item->list->is_system) {
                $this->handleSystemListSubItem($item);
                return;
            }
            throw new AuthorizationException(__('You are not authorized to perform this action.'));
        }

        $this->createSubItem($item);
    }

    /**
     * Handle sub-item creation for system lists
     */
    protected function handleSystemListSubItem(DynamicListItem $item): void
    {
        $user = Auth::user();
        $clonedList = $this->getOrCreateClonedList($item->list, $user->agency_id);

        $newItem = $clonedList->items()
            ->where('label', $item->label)
            ->first();

        if ($newItem) {
            $this->createSubItem($newItem);
            $this->expandedLists = array_unique([...$this->expandedLists, $clonedList->id]);
            $this->dispatch('subitem-added',
                listId: $clonedList->id,
                itemId: $newItem->id
            );
        }
    }

    /**
     * Create new sub-item
     */
    protected function createSubItem(DynamicListItem $item): void
    {
        $newSubItem = $item->subItems()->create([
            'label' => $this->subItemLabel[$item->id],
            'order' => $item->subItems()->count() + 1,
        ]);

        if (!$item->relationLoaded('subItems')) {
            $item->setRelation('subItems', collect());
        }

        $item->subItems->push($newSubItem);
        $this->subItemLabel[$item->id] = '';

        $this->dispatch('subitem-added',
            listId: $item->list->id,
            itemId: $item->id
        );
    }

    /**
     * Get or create cloned list
     */
    protected function getOrCreateClonedList(DynamicList $systemList, int $agencyId): DynamicList
    {
        return $this->clonedListsCache[$systemList->id] ??= DynamicList::with(['items.subItems'])
            ->where('original_id', $systemList->id)
            ->where('agency_id', $agencyId)
            ->firstOr(function () use ($systemList, $agencyId) {
                return $systemList->createAgencyCopy($agencyId)
                    ->load(['items.subItems']);
            });
    }

    /**
     * Start editing sub-item
     */
    public function startEditSubItem(int $subItemId): void
    {
        $subItem = DynamicListItemSub::with('item.list')->findOrFail($subItemId);

        if (!Auth::user()->canEditList($subItem->item->list)) {
            throw new AuthorizationException(__('You are not authorized to edit this item.'));
        }

        $this->editingSubItemId = $subItem->id;
        $this->editingSubItemLabel = $subItem->label;
    }

    /**
     * Update sub-item
     */
    public function updateSubItem(): void
    {
        $this->validate([
            'editingSubItemLabel' => 'required|string|max:255',
        ]);

        $subItem = DynamicListItemSub::with('item.list')->findOrFail($this->editingSubItemId);

        if (!Auth::user()->canEditList($subItem->item->list)) {
            throw new AuthorizationException(__('You are not authorized to update this item.'));
        }

        $subItem->update(['label' => $this->editingSubItemLabel]);
        $this->cancelEditSubItem();
        $this->dispatch('subitem-updated');
    }

    /**
     * Delete sub-item
     */
    public function deleteSubItem(int $subItemId): void
    {
        $subItem = DynamicListItemSub::with('item.list')->findOrFail($subItemId);

        if (!Auth::user()->canEditList($subItem->item->list)) {
            throw new AuthorizationException(__('You are not authorized to delete this item.'));
        }

        $subItem->delete();
        $this->dispatch('subitem-deleted');
    }

    /**
     * Cancel sub-item editing
     */
    public function cancelEditSubItem(): void
    {
        $this->editingSubItemId = null;
        $this->editingSubItemLabel = '';
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.agency.dynamic-lists')
            ->with([
                'lists' => $this->lists,
            ]);
    }
}

<?php

namespace App\Livewire\Agency;

use App\Models\DynamicList;
use App\Models\DynamicListItem;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.agency')]
class DynamicLists extends Component
{
    public $lists;
    public $listName = '';
    public $expandedLists = [];
    public array $itemLabel = [];
    public array $editingItems = [];

    public function mount()
    {
        $this->loadLists();
    }

    public function loadLists()
    {
        $this->lists = DynamicList::with('items')->orderBy('id', 'desc')->get();
    }

    public function saveList()
    {
        $this->validate(['listName' => 'required|string|max:255']);

        DynamicList::create(['name' => $this->listName]);
        $this->reset('listName');
        $this->loadLists();
    }

    public function deleteList($id)
    {
        DynamicList::findOrFail($id)->delete();
        $this->loadLists();
    }

    public function toggleExpand($id)
    {
        if (in_array($id, $this->expandedLists)) {
            $this->expandedLists = array_diff($this->expandedLists, [$id]);
        } else {
            $this->expandedLists[] = $id;
        }
    }

    public function addItem($listId)
    {
        $this->validate([
            'itemLabel.' . $listId => 'required|string|max:255',
        ]);

        DynamicListItem::create([
            'dynamic_list_id' => $listId,
            'label' => $this->itemLabel[$listId],
        ]);

        unset($this->itemLabel[$listId]);
        $this->loadLists();
    }

    public function editItem($listId, $itemId)
    {
        $item = DynamicListItem::findOrFail($itemId);
        $this->editingItems[$listId] = $itemId;
        $this->itemLabel[$listId] = $item->label;
    }

    public function updateItem($listId)
    {
        $itemId = $this->editingItems[$listId] ?? null;

        if ($itemId) {
            $this->validate([
                'itemLabel.' . $listId => 'required|string|max:255',
            ]);

            $item = DynamicListItem::find($itemId);
            if ($item) {
                $item->update(['label' => $this->itemLabel[$listId]]);
            }

            unset($this->editingItems[$listId]);
            unset($this->itemLabel[$listId]);
            $this->loadLists();
        }
    }

    public function deleteItem($listId, $itemId)
    {
        DynamicListItem::findOrFail($itemId)->delete();
        $this->loadLists();
    }

    public function render()
    {
        return view('livewire.agency.dynamic-lists');
    }
}

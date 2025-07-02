import './bootstrap';
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Initialize Livewire
Livewire.start();

// Add error handling
window.addEventListener('livewire:load', () => {
    console.log('Livewire loaded successfully');
});

window.addEventListener('livewire:error', (event) => {
    console.error('Livewire error:', event.detail);
});

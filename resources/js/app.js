import './bootstrap';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import './../../vendor/power-components/livewire-powergrid/dist/powergrid.css'

// Alpine JS
import Alpine from "alpinejs";
import persist from '@alpinejs/persist'

Alpine.plugin(persist)
window.Alpine = Alpine;

Alpine.start();


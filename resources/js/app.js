import './bootstrap';
import './../../vendor/power-components/livewire-powergrid/dist/tailwind.css';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';
import '../../public/sw.js'

if (!navigator.serviceWorker.controller) {
    navigator.serviceWorker.register("/sw.js").then(function (reg) {
        console.log("Service worker has been registered for scope: " + reg.scope);
    });
}

import flatpickr from "flatpickr";
window.flatpickr = flatpickr;

import TomSelect from "tom-select";
window.TomSelect = TomSelect

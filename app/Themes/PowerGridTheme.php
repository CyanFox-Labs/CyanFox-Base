<?php

namespace App\Themes;

use PowerComponents\LivewirePowerGrid\Themes\Components\Actions;
use PowerComponents\LivewirePowerGrid\Themes\Components\Checkbox;
use PowerComponents\LivewirePowerGrid\Themes\Components\Cols;
use PowerComponents\LivewirePowerGrid\Themes\Components\Editable;
use PowerComponents\LivewirePowerGrid\Themes\Components\FilterBoolean;
use PowerComponents\LivewirePowerGrid\Themes\Components\FilterDatePicker;
use PowerComponents\LivewirePowerGrid\Themes\Components\FilterInputText;
use PowerComponents\LivewirePowerGrid\Themes\Components\FilterMultiSelect;
use PowerComponents\LivewirePowerGrid\Themes\Components\FilterNumber;
use PowerComponents\LivewirePowerGrid\Themes\Components\FilterSelect;
use PowerComponents\LivewirePowerGrid\Themes\Components\Footer;
use PowerComponents\LivewirePowerGrid\Themes\Components\Radio;
use PowerComponents\LivewirePowerGrid\Themes\Components\SearchBox;
use PowerComponents\LivewirePowerGrid\Themes\Components\Table;
use PowerComponents\LivewirePowerGrid\Themes\Theme;
use PowerComponents\LivewirePowerGrid\Themes\ThemeBase;

class PowerGridTheme extends ThemeBase
{
    public string $name = 'tailwind';

    public function table(): Table
    {
        return Theme::table('min-w-full dark:!bg-dark-700')
            ->div('rounded-t-lg relative border-x border-t border-gray-200 dark:bg-dark-700 dark:border-dark-600')
            ->thead('shadow-sm rounded-t-lg bg-gray-100 dark:bg-dark-900')
            ->thAction('!font-bold')
            ->tdAction('')
            ->tr('dark:bg-dark-700 bg-white')
            ->trFilters('bg-white shadow-sm dark:bg-dark-700')
            ->th('font-extrabold px-2 pr-4 py-3 text-left text-xs text-gray-700 tracking-wider whitespace-nowrap dark:text-dark-300')
            ->tbody('text-dark-700')
            ->trBody('border-b border-gray-100 dark:border-dark-600 hover:bg-gray-50 dark:bg-dark-700 dark:hover:bg-dark-600')
            ->tdBody('p-2 whitespace-nowrap dark:text-dark-200')
            ->tdBodyEmpty('p-2 whitespace-nowrap dark:text-dark-200')
            ->trBodyClassTotalColumns('')
            ->tdBodyTotalColumns('p-2 whitespace-nowrap dark:text-dark-200 text-sm text-gray-600 text-right space-y-2');
    }

    public function footer(): Footer
    {
        return Theme::footer()
            ->view($this->root() . '.footer')
            ->select('appearance-none !bg-none focus:ring-dark-600 focus-within:focus:ring-dark-600 focus-within:ring-dark-600 dark:focus-within:ring-dark-600 flex rounded-md ring-1 transition focus-within:ring-2 dark:ring-dark-600 dark:text-dark-300 text-gray-600 ring-gray-300 dark:bg-dark-700 bg-white dark:placeholder-dark-400 rounded-md border-0 bg-transparent py-1.5 px-4 pr-7 ring-0 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6 w-auto');
    }

    public function actions(): Actions
    {
        return Theme::actions()
            ->headerBtn('block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-dark-600 dark:bg-dark-700 dark:text-dark-200 dark:placeholder-dark-300 dark:border-dark-600')
            ->rowsBtn('focus:outline-none text-sm py-2.5 px-5 rounded border');
    }

    public function cols(): Cols
    {
        return Theme::cols()
            ->div('select-none flex items-center gap-2')
            ->clearFilter('', '');
    }

    public function editable(): Editable
    {
        return Theme::editable()
            ->view($this->root() . '.editable')
            ->span('flex justify-between')
            ->input('focus:ring-dark-600 focus-within:focus:ring-dark-600 focus-within:ring-dark-600 dark:focus-within:ring-dark-600 flex rounded-md ring-1 transition focus-within:ring-2 dark:ring-dark-600 dark:text-dark-300 text-gray-600 ring-gray-300 dark:bg-dark-700 bg-white dark:placeholder-dark-400 w-full rounded-md border-0 bg-transparent py-1.5 px-2 ring-0 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6 w-full');
    }

    public function checkbox(): Checkbox
    {
        return Theme::checkbox()
            ->th('px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider')
            ->label('flex items-center space-x-3')
            ->input('form-checkbox dark:border-dark-600 border-1 dark:bg-dark-700 rounded border-gray-300 bg-white transition duration-100 ease-in-out h-4 w-4 text-gray-500 focus:ring-dark-500 dark:ring-offset-dark-900');
    }

    public function radio(): Radio
    {
        return Theme::radio()
            ->th('px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider')
            ->label('flex items-center space-x-3')
            ->input('form-radio rounded-full transition ease-in-out duration-100');
    }

    public function filterBoolean(): FilterBoolean
    {
        return Theme::filterBoolean()
            ->view($this->root() . '.filters.boolean')
            ->base('min-w-[5rem]')
            ->select('appearance-none !bg-none focus:ring-dark-600 focus-within:focus:ring-dark-600 focus-within:ring-dark-600 dark:focus-within:ring-dark-600 flex rounded-md ring-1 transition focus-within:ring-2 dark:ring-dark-600 dark:text-dark-300 text-gray-600 ring-gray-300 dark:bg-dark-700 bg-white dark:placeholder-dark-400 w-full rounded-md border-0 bg-transparent py-1.5 px-2 ring-0 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6 w-full');
    }

    public function filterDatePicker(): FilterDatePicker
    {
        return Theme::filterDatePicker()
            ->base()
            ->view($this->root() . '.filters.date-picker')
            ->input('flatpickr flatpickr-input focus:ring-dark-600 focus-within:focus:ring-dark-600 focus-within:ring-dark-600 dark:focus-within:ring-dark-600 flex rounded-md ring-1 transition focus-within:ring-2 dark:ring-dark-600 dark:text-dark-300 text-gray-600 ring-gray-300 dark:bg-dark-700 bg-white dark:placeholder-dark-400 w-full rounded-md border-0 bg-transparent py-1.5 px-2 ring-0 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6 w-auto');
    }

    public function filterMultiSelect(): FilterMultiSelect
    {
        return Theme::filterMultiSelect()
            ->base('inline-block relative w-full')
            ->select('mt-1')
            ->view($this->root() . '.filters.multi-select');
    }

    public function filterNumber(): FilterNumber
    {
        return Theme::filterNumber()
            ->view($this->root() . '.filters.number')
            ->input('w-full min-w-[5rem] block focus:ring-dark-600 focus-within:focus:ring-dark-600 focus-within:ring-dark-600 dark:focus-within:ring-dark-600 flex rounded-md ring-1 transition focus-within:ring-2 dark:ring-dark-600 dark:text-dark-300 text-gray-600 ring-gray-300 dark:bg-dark-700 bg-white dark:placeholder-dark-400 rounded-md border-0 bg-transparent py-1.5 pl-2 ring-0 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6');
    }

    public function filterSelect(): FilterSelect
    {
        return Theme::filterSelect()
            ->view($this->root() . '.filters.select')
            ->base('min-w-[9.5rem]')
            ->select('appearance-none !bg-none focus:ring-dark-600 focus-within:focus:ring-dark-600 focus-within:ring-dark-600 dark:focus-within:ring-dark-600 flex rounded-md ring-1 transition focus-within:ring-2 dark:ring-dark-600 dark:text-dark-300 text-gray-600 ring-gray-300 dark:bg-dark-700 bg-white dark:placeholder-dark-400 rounded-md border-0 bg-transparent py-1.5 px-2 ring-0 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6 w-full');
    }

    public function filterInputText(): FilterInputText
    {
        return Theme::filterInputText()
            ->view($this->root() . '.filters.input-text')
            ->base('min-w-[9.5rem]')
            ->select('appearance-none !bg-none focus:ring-dark-600 focus-within:focus:ring-dark-600 focus-within:ring-dark-600 dark:focus-within:ring-dark-600 flex rounded-md ring-1 transition focus-within:ring-2 dark:ring-dark-600 dark:text-dark-300 text-gray-600 ring-gray-300 dark:bg-dark-700 bg-white dark:placeholder-dark-400 w-full rounded-md border-0 bg-transparent py-1.5 px-2 ring-0 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6 w-full')
            ->input('focus:ring-dark-600 focus-within:focus:ring-dark-600 focus-within:ring-dark-600 dark:focus-within:ring-dark-600 flex rounded-md ring-1 transition focus-within:ring-2 dark:ring-dark-600 dark:text-dark-300 text-gray-600 ring-gray-300 dark:bg-dark-700 bg-white dark:placeholder-dark-400 w-full rounded-md border-0 bg-transparent py-1.5 px-2 ring-0 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6 w-full');
    }

    public function searchBox(): SearchBox
    {
        return Theme::searchBox()
            ->input('focus:ring-dark-600 focus-within:focus:ring-dark-600 focus-within:ring-dark-600 dark:focus-within:ring-dark-600 flex items-center rounded-md ring-1 transition focus-within:ring-2 dark:ring-dark-600 dark:text-dark-300 text-gray-600 ring-gray-300 dark:bg-dark-700 bg-white dark:placeholder-dark-400 w-full rounded-md border-0 bg-transparent py-1.5 px-2 ring-0 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6 w-full pl-8')
            ->iconClose('text-dark-400 dark:text-dark-200')
            ->iconSearch('text-dark-300 mr-2 w-5 h-5 dark:text-dark-200');
    }
}

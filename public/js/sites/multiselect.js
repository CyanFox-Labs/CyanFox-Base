let values = [];
document.addEventListener("alpine:init", () => {
    Alpine.data("multiselect", () => ({
        style: {
            wrapper: "w-full relative",
            select:
                "border w-full select select-bordered py-2 px-2 text-sm flex gap-2 items-center cursor-pointer",
            menuWrapper:
                "w-full rounded-lg py-1.5 text-sm mt-1 shadow-lg absolute bg-base-100 z-10",
            menu: "max-h-52 overflow-y-auto",
            textList: "overflow-x-hidden text-ellipsis grow whitespace-nowrap",
            trigger: "px-2 py-2 rounded",
            badge: "py-1.5 px-3 rounded-full",
            search:
                "px-3 py-2 w-full border-0 input border-b-2 pb-3 outline-0 mb-1",
            optionGroupTitle:
                "px-3 py-2 text-neutral-400 uppercase font-bold text-xs sticky top-0",
            clearSearchBtn: "absolute p-3 right-0 top-1",
            label: "cursor-pointer flex py-2 px-3"
        },

        init() {
            const style = this.style;

            const originalSelect = this.$el;
            originalSelect.classList.add("hidden");

            const wrapper = document.createElement("div");
            wrapper.className = style.wrapper;
            wrapper.setAttribute("x-data", "newSelect");

            const newSelect = document.createElement("div");
            newSelect.className = style.select;
            newSelect.setAttribute("x-bind", "selectTrigger");

            const textList = document.createElement("span");
            textList.className = style.textList;

            const triggerBtn = document.createElement("button");
            triggerBtn.className = style.trigger;

            const countBadge = document.createElement("span");
            countBadge.className = style.badge;
            countBadge.setAttribute("x-bind", "countBadge");

            newSelect.append(textList);
            newSelect.append(countBadge);
            newSelect.append(triggerBtn);

            const menuWrapper = document.createElement("div");
            menuWrapper.className = style.menuWrapper;
            menuWrapper.setAttribute("x-bind", "selectMenu");

            const menu = document.createElement("div");
            menu.className = style.menu;

            const search = document.createElement("input");
            search.className = style.search;
            search.setAttribute("x-bind", "search");
            search.setAttribute("placeholder", "Filter"); // TODO: Translate

            menuWrapper.append(search);
            menuWrapper.append(menu);

            originalSelect.parentNode.insertBefore(
                wrapper,
                originalSelect.nextSibling
            );

            this.items = this.$el.querySelectorAll("li");
            const preselectedValues = Array.from(this.items)
                .map(item => item.querySelector("input[type=checkbox]"))
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            Livewire.dispatch('updateMultiSelect', {values: preselectedValues});

            const itemGroups = originalSelect.querySelectorAll("optgroup");

            if (itemGroups.length > 0) {
                itemGroups.forEach((itemGroup) => processItems(itemGroup));
            } else {
                processItems(originalSelect);
            }

            function processItems(parent) {
                const items = parent.querySelectorAll("option");
                const subMenu = document.createElement("ul");
                const groupName = parent.getAttribute("label") || null;

                if (groupName) {
                    const groupTitle = document.createElement("h5");
                    groupTitle.className = style.optionGroupTitle;
                    groupTitle.innerText = groupName;
                    groupTitle.setAttribute("x-bind", "groupTitle");
                    menu.appendChild(groupTitle);
                }

                items.forEach((item) => {
                    const li = document.createElement("li");
                    li.setAttribute("x-bind", "listItem");

                    const checkBox = document.createElement("input");
                    checkBox.classList.add("mr-3", "checkbox");
                    checkBox.type = "checkbox";
                    checkBox.value = item.value;
                    checkBox.id = originalSelect.name + "_" + item.value;

                    const label = document.createElement("label");
                    label.className = style.label;
                    label.setAttribute("for", checkBox.id);
                    label.innerText = item.innerText;

                    checkBox.setAttribute("x-bind", "checkBox");

                    if (item.hasAttribute("selected")) {
                        checkBox.checked = true;
                    }
                    label.prepend(checkBox);
                    li.append(label);
                    subMenu.appendChild(li);
                });
                menu.appendChild(subMenu);
            }

            wrapper.appendChild(newSelect);
            wrapper.appendChild(menuWrapper);

            Alpine.data("newSelect", () => ({
                open: false,
                showCountBadge: false,
                items: [],
                selectedItems: [],
                filterBy: "",
                init() {
                    this.regenerateTextItems();
                },

                regenerateTextItems() {
                    this.selectedItems = [];
                    this.items.forEach((item) => {
                        const checkbox = item.querySelector("input[type=checkbox]");
                        const text = item.querySelector("label").innerText;
                        if (checkbox.checked) {
                            this.selectedItems.push(text);
                        }
                    });

                    if (this.selectedItems.length > 1) {
                        this.showCountBadge = true;
                    } else {
                        this.showCountBadge = false;
                    }

                    if (this.selectedItems.length === 0) {
                        textList.innerHTML = '';
                    } else {
                        textList.innerText = this.selectedItems.join(", ");
                    }
                },

                selectTrigger: {
                    ["@click"]() {
                        this.open = !this.open;

                        if (this.open) {
                            this.$nextTick(() =>
                                this.$root.querySelector("input[x-bind=search]").focus()
                            );
                        }
                    }
                },
                selectMenu: {
                    ["x-show"]() {
                        return this.open;
                    },
                    ["x-transition"]() {
                    },
                    ["@keydown.escape.window"]() {
                        this.open = false;
                    },
                    ["@click.away"]() {
                        this.open = false;
                    },
                    ["x-init"]() {
                        this.items = this.$el.querySelectorAll("li");
                        this.regenerateTextItems();
                    }
                },
                checkBox: {
                    ["@change"]() {
                        const checkBox = this.$el;

                        if (checkBox.checked) {
                            values.push(checkBox.value);
                            originalSelect
                                .querySelector("option[value='" + checkBox.value + "']")
                                .setAttribute("selected", true);
                        } else {
                            // Remove unchecked value from selectedRoles
                            const index = values.indexOf(checkBox.value);
                            if (index > -1) {
                                values.splice(index, 1);
                            }

                            originalSelect
                                .querySelector("option[value='" + checkBox.value + "']")
                                .removeAttribute("selected");
                        }

                        Livewire.dispatch('updateMultiSelect', {values: values});
                        this.regenerateTextItems();
                    }
                },
                countBadge: {
                    ["x-show"]() {
                        return this.showCountBadge;
                    },
                    ["x-text"]() {
                        return this.selectedItems.length;
                    }
                },
                search: {
                    ["@keydown.escape.stop"]() {
                        this.filterBy = "";
                        this.$el.blur();
                    },
                    ["@keyup"]() {
                        this.filterBy = this.$el.value;
                    },
                    ["x-model"]() {
                        return this.filterBy;
                    }
                },
                clearSearchBtn: {
                    ["@click"]() {
                        this.filterBy = "";
                    },
                    ["x-show"]() {
                        return this.filterBy.length > 0;
                    }
                },
                listItem: {
                    ["x-show"]() {
                        return (
                            this.filterBy === "" ||
                            this.$el.innerText
                                .toLowerCase()
                                .startsWith(this.filterBy.toLowerCase())
                        );
                    }
                },
                groupTitle: {
                    ["x-show"]() {
                        if (this.filterBy === "") return true;

                        let atLeastOneItemIsShown = false;

                        this.$el.nextElementSibling
                            .querySelectorAll("li")
                            .forEach((item) => {
                                console.log(this.filterBy);
                                if (
                                    item.innerText
                                        .toLowerCase()
                                        .startsWith(this.filterBy.toLowerCase())
                                )
                                    atLeastOneItemIsShown = true;
                            });
                        return atLeastOneItemIsShown;
                    }
                }
            }));
        }
    }));
});

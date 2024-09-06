const wrapper = document.querySelector(".wrapper"),
options = wrapper.querySelector(".options"),
newSearchInput = wrapper.querySelector("input");

function addItem(selectedItem) {
    const options = document.querySelectorAll('.options');
    options.forEach(optionList => {
        optionList.innerHTML = "";
        itemsData.forEach(item => {
            let isSelected = item.iname === selectedItem ? "selected" : "";
            let li = `<li onclick="updateName(this)" class="${isSelected}" data-id="${item.item_id}">${item.iname}</li>`;
            optionList.insertAdjacentHTML("beforeend", li);
        });
    });
}

function updateName(selectedLi, itemCount) {
    const searchInp = document.getElementById(`item-${itemCount}`);
    searchInp.value = selectedLi.innerText;
    searchInp.setAttribute('data-id', selectedLi.getAttribute('data-id'));
}
newSearchInput.addEventListener('input', function() {
    options.style.display = 'block';
});
newSearchInput.addEventListener('keyup', function() {
    let searchWord = newSearchInput.value.toLowerCase();
    let filteredItems = itemsData.filter(item => {
        return item.iname.toLowerCase().startsWith(searchWord);
    }).map(item => {
        return `<li onclick="updateName(this, ${itemCount})" data-id="${item.item_id}">${item.iname}</li>`;
    }).join("");

    options.innerHTML = filteredItems || `<p style="margin-top: 10px;">Not found</p>`;

});
options.addEventListener('click', function(){
    options.style.display = 'none';
});

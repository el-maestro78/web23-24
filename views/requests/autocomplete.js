const wrapper = document.querySelector(".wrapper"),
selectBtn = wrapper.querySelector(".select-btn"),
searchInp = wrapper.querySelector("input"),
options = wrapper.querySelector(".options");

function addItem(selectedItem) {
    options.innerHTML = "";
    itemsData.forEach(item => {
        let isSelected = item.iname === selectedItem ? "selected" : "";
        let li = `<li onclick="updateName(this)" class="${isSelected}" data-id="${item.item_id}">${item.iname}</li>`;
        options.insertAdjacentHTML("beforeend", li);
    });
}

function updateName(selectedLi) {
    searchInp.value = "";
    addItem(selectedLi.innerText);  // Here you are passing the item name
    wrapper.classList.remove("active");
    selectBtn.firstElementChild.innerText = selectedLi.innerText;  // Set the name
}
searchInp.addEventListener("keyup", () => {
    let arr = [];
    let searchWord = searchInp.value.toLowerCase();
    arr = itemsData.filter(item => {
        return item.iname.toLowerCase().startsWith(searchWord);  // Filter by item name
    }).map(item => {
        let isSelected = item.iname === selectBtn.firstElementChild.innerText ? "selected" : "";
        return `<li onclick="updateName(this)" class="${isSelected}" data-id="${item.item_id}">${item.iname}</li>`;
    }).join("");

    options.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Not found</p>`;
});

selectBtn.addEventListener("click", function(event){
    event.preventDefault();
    wrapper.classList.toggle("active");
    autocomplete(document.getElementById("item"), itemsData);
})

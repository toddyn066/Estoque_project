const searchWrapper = document.querySelector(".search");
const inputBox = searchWrapper.querySelector("input");
const sugestBox = searchWrapper.querySelector(".list");

let selectedIndex = -1;

inputBox.onkeyup = (e)=>{
    let userData = e.target.value;
    let emptyArray = [];

    
    if(userData){
        emptyArray = suggestions.filter((data)=>{
            return data.toLocaleLowerCase().startsWith(userData.toLocaleLowerCase());
        });
        emptyArray = emptyArray.map((data)=>{
            return data = `<li>${data}</li>`;
        });
        
        searchWrapper.classList.add("active");
        showSuggestions(emptyArray);
        let allList = sugestBox.querySelectorAll("li");
        for(let i=0; i < allList.length; i++){
            allList[i].setAttribute("onclick", "select(this)");
        }
        
        if(e.key === 'Escape'){
            searchWrapper.classList.remove("active");
        }

    }
    else{
        searchWrapper.classList.remove("active");   
    }

    const isArrowUp = e.key === "ArrowUp";
    const isArrowDown = e.key === "ArrowDown";
    let allList = sugestBox.querySelectorAll("li");

    if (isArrowUp || isArrowDown) {
        e.preventDefault();
        selectedIndex += isArrowUp ? -1 : 1;
        selectedIndex = Math.max(-1, Math.min(selectedIndex, allList.length));

        if (selectedIndex < 0) {
            selectedIndex = allList.length - 1;
        } else if (selectedIndex >= allList.length) {
            selectedIndex = 0;
        }
        updateSelectedSuggestion();
    }

    document.querySelector('form').addEventListener('keypress', (event) => {
        if (userData.length > 0) {
            if(event.key === 'Enter' && !document.querySelector('button[type="submit"]').focus()){
                inputBox.value = document.querySelector("li.selected").textContent;
                event.preventDefault();
                searchWrapper.classList.remove("active");   
                document.querySelector('button[type="submit"]').focus();
            }
        }
       

        document.querySelector('button[type="submit"]').addEventListener('keypress', () => {
            if ( event.key === 'Enter') {
                document.querySelector('form').submit();
            }
        });
    });
}

function select(element){
    let selectData = element.textContent;
    inputBox.value = selectData;

    searchWrapper.classList.remove("active");
}

function showSuggestions(list){
    let listData;
    console.log(!list.length);
    if(!list.length){
        userValue = inputBox.value;
        listData = `<li>${userValue}</li>`;
    }else{
      listData = list.join('');
    }
    sugestBox.innerHTML = listData;
}

function updateSelectedSuggestion() {
    const selected = sugestBox.querySelectorAll("li");
    selected.forEach(li => li.classList.remove("selected"));
    if (selectedIndex !== -1) {
        selected[selectedIndex].classList.add("selected");
    }
}
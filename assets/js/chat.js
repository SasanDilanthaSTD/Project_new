const form = document.querySelector(".typing-area"),
    inputfield = form.querySelector(".input-field"),
    sendbutton = form.querySelector("button"),
    chatbox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();
}

sendbutton.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST","process/chatInsert.php",true);
    xhr.onload = ()=>{
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputfield.value = "";
            }
        }
    }

    let formData = new FormData(form);
    xhr.send(formData);
}

setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST","process/getChat.php",true);
    xhr.onload = ()=>{
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatbox.innerHTML = data;
            }
        }
    }

    let formData = new FormData(form);
    xhr.send(formData);
},500);
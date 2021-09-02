//selecting all required elements
const form = document.querySelector(".wrapper form"),
fullURL = form.querySelector("input"),
shortenBtn = form.querySelector("form button"),
blurEffect = document.querySelector(".blur-effect"),
popupBox = document.querySelector(".popup-box"),
infoBox = popupBox.querySelector(".info-box"),
form2 = popupBox.querySelector("form"),
shortenURL = popupBox.querySelector("form .shorten-url"),
copyIcon = popupBox.querySelector("form .copy-icon"),
saveBtn = popupBox.querySelector("button");

form.onsubmit = (e)=>{
    e.preventDefault();//prevent form submission
}

shortenBtn.onclick = ()=>{
    //ajax code
    let xhr = new XMLHttpRequest();//creating xhr object
    xhr.open("POST", "php/url-controll.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){//if status code is 200
            let data = xhr.response;
            if(data.length <= 5){
                blurEffect.style.display = "block";
                popupBox.classList.add("show");

                let domain = "localhost/url/"; 
                shortenURL.value = domain + data;
                // copylink javascript code
                copyIcon.onclick = ()=>{
                    shortenURL.select();
                    document.execCommand("copy");
                }
                // save button
                saveBtn.onclick = ()=>{
                    form2.onsubmit = (e)=>{
                        e.preventDefault();
                    }

                    let xhr2 = new XMLHttpRequest();
                    xhr2.open("POST", "php/save-url.php", true);
                    xhr2.onload = ()=>{
                        if(xhr2.readyState == 4 && xhr2.status == 200){
                            let data = xhr2.response;
                            if(data == "success"){
                                location.reload();//reload current page
                            }else{
                                infoBox.classList.add("error");
                                infoBox.innerText = data;
                            }
                        }
                    }
                    // send two data from ajax to php
                    let shorten_url1 = shortenURL.value;
                    let hidden_url = data;
                    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr2.send("shorten_url="+shorten_url1+"&hidden_url="+hidden_url);
                }
            }else{
                alert(data);
            }
        }
    }
    // send form data to php file
    let formData = new FormData(form);//creating new formdata object
    xhr.send(formData);//sending form value to php
}
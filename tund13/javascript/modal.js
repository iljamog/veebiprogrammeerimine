let modal;
let modalImg;
let captionText;
let photoDir = "../pic_upload_W600_H400/";
let photoId;

window.onload = function(){
	modal = document.getElementById("myModal");
	modalImg = document.getElementById("modalImg");
	captionText = document.getElementById("caption");
	let allThumbs = document.getElementById("gallery").getElementsByTagName("img");
	let thumbCount = allThumbs.length;
	for(let i = 0; i < thumbCount; i ++){
		allThumbs[i].addEventListener("click", openModal);
	}
	document.getElementById("close").addEventListener("click", closeModal);
	document.getElementById("storeRating").addEventListener("click", storeRating);
}

function storeRating(){
	let rating = 0;
	for(let i = 1; i < 6; i ++){
		if(document.getElementById("rate" + i).checked){
			rating = document.getElementById("rate" + i).value;
		}
	}
	
	if(rating > 0){
		//AJAX
		let webRequest = new XMLHttpRequest();
		webRequest.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				//console.log("Edu: " + this.responseText);
				document.getElementById("avgRating").innerHTML = "Keskmine hinne: " + this.responseText;
				document.getElementById("score" + photoId).innerHTML = "Hinne: " + this.responseText;
			}
		}
		console.log("savePhotoRating.php?rating=" + rating + "&photoid=" + photoId);
		webRequest.open("GET", "savePhotoRating.php?rating=" + rating + "&photoid=" + photoId, true);
		webRequest.send();
	}
}

function openModal(e){
	for(let i = 1; i < 6; i ++){
		document.getElementById("rate" + i).checked = false;
	}
	//console.log(e);
	modalImg.src = photoDir + e.target.dataset.fn;
	photoId = e.target.dataset.id;
	captionText.innerHTML = "<p>" + e.target.alt + "</p>";
	document.getElementById("avgRating").innerHTML = "";
	modal.style.display = "block";
}

function closeModal(){
	modal.style.display = "none";
}









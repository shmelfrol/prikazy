let input=document.getElementById("prikazcreateform-file");

var inputFunction = function(){
    let countFiles = '';
    let filename = '';
    let fileNameDiv= document.getElementById("uploadedfile");
    if (this.files && this.files.length >= 1)
        countFiles = this.files.length;
    filename = this.files[0].name;
    fileNameDiv.textContent=filename;
}






input.addEventListener('change', inputFunction, false);



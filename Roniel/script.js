function saveFile() {
    const test = document.getElementById("test");
    const test1 = document.getElementById("test1");
    const test2 = document.getElementById("test2");

    let data = test.value + " " + test1.value + " " + test2.value;

    const textToBlob = new Blob([data], { type: 'text/plain' });
    const sFileName = 'fileTest.txt';

    let newlink = document.createElement('a');
    newlink.download = sFileName;

    if (window.webkitURL != null) {
        newlink.href = window.webkitURL.createObjectURL(textToBlob);
    }
    else {
        newlink.href = window.URL.webkitURL.createObjectURL(textToBlob);
        newlink.style.display = "none";
        document.body.appendChild(newlink);
    }

    newlink.click();
}
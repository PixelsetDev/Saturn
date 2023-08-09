
const xhr = new XMLHttpRequest();
xhr.open("GET", "/panel/api/statistics");
xhr.send();
xhr.responseType = "json";
xhr.onload = () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
        document.getElementById('PageCount').innerHTML = xhr.response.pages;
    } else {
        console.log(`Error: ${xhr.status}`);
    }
};
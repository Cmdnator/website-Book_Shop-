const ApiKey = "AIzaSyCnvcGOjW1XoXrKOAvv-tIt5OyIw8xoTZ0";
const isbnForm = document.querySelector(".submitISBN");

isbnForm.addEventListener("submit", async event => {
    event.preventDefault();
    const isbn = document.getElementById("isbn").value;

    if(isbn){
        try{
            const BookData = await getData(isbn);
            displayInfo(BookData);
        } 
        catch(err){
            alert("Fetching Data Error");
        }
    }
    else{
        alert("Please Enter ISBN Number");
    }
});

async function getData(isbn){
    try{
        const Data = await fetch(`https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}&key=${ApiKey}`);

        const bookData = await Data.json();
    
        if (!bookData.items || bookData.items.length === 0) {
            alert("Book not found");
        return null;
    }

       const matchedBook = bookData.items.find(item => 
            item.volumeInfo.industryIdentifiers?.some(id => id.identifier === isbn)
        );

        return matchedBook || bookData.items[0]; // fallback if exact match not found
    } 
    catch(err){
        alert("Failed to fetch book info");
    }
}

function displayInfo(data){
    if (!data) return;

    const bookCover = document.querySelector(".bookCover");
    bookCover.style.display = "grid";

    const volumeInfo = data.volumeInfo;

    // Book cover
    const coverImg = document.getElementById("coverImg");
    if (volumeInfo.imageLinks && volumeInfo.imageLinks.thumbnail) {
        coverImg.src = volumeInfo.imageLinks.thumbnail;
    } else {
        coverImg.src = ""; 
    }

    // Book title
    const titleInput = document.getElementById("title");
    titleInput.textContent  = volumeInfo.title || "";

    // Book author
    const authorInput = document.getElementById("author");
    if (volumeInfo.authors) {
        authorInput.textContent  = volumeInfo.authors.join(", ");
    } else {
        authorInput.textContent  = "";
    }

    //Category
    const category = document.getElementById("category");

    if (volumeInfo.categories) {
        category.textContent = volumeInfo.categories.join(", ");
    } else {
        category.textContent = "";
    }

    //Book price(random because Google API doesnt contain info about book`s price)
    const price = document.getElementById("price");
    let Rprice  =  ((Math.random() * 41) + 10);
    Rprice = +Rprice.toFixed(2);
    price.textContent  = ("$" + Rprice) || "";
}

document.getElementById("saveBook").addEventListener("click", async () => {

    const title = document.getElementById("title").textContent;
    const author = document.getElementById("author").textContent;
    const price = document.getElementById("price").textContent.replace("$", "");
    const category = document.getElementById("category").textContent;
    const cover = document.getElementById("coverImg").src;

    const response = await fetch("../phpFunctions/add_Book.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            title,
            author,
            price,
            category,
            cover
        })
    });

    const result = await response.text();
    alert(result);
    location.reload();
});
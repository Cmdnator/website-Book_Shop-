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

async function getData(isbn) {
    try {
        const response = await fetch(`http://localhost:3000/api/data?isbn=${isbn}`);
        
        // If the server sent "ISBN is required" (400) or "Google rejected" (403/500)
        if (!response.ok) {
            const errorData = await response.json();
            alert(`Server Error: ${errorData.error}`);
            return null;
        }

        const bookData = await response.json();
    
        if (!bookData.items || bookData.items.length === 0) {
            alert("Book not found");
            return null;
        }

        const matchedBook = bookData.items.find(item => 
            item.volumeInfo.industryIdentifiers?.some(id => id.identifier === isbn)
        );

        return matchedBook || bookData.items[0]; 
    } 
    catch(err) {
        console.error("Connection Error:", err);
        alert("Check if your Node server is running on port 3000");
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
        authorInput.textContent  = "Unknown Author";
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
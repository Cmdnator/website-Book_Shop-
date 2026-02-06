const ApiKey = 
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

        return bookData.items[0];
    } 
    catch(err){
        alert("Failed to fetch book info");
    }
}

function displayInfo(data){
    console.log(data);
}
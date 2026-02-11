
require('dotenv').config({ override: true });
const express = require('express');
const cors = require('cors'); // 1. Import cors
const app = express();
app.use(cors());

app.get('/api/data', async (req, res) => {
  const { isbn } = req.query; // Get ISBN from request query
  if (!isbn) return res.status(400).json({ error: "ISBN is required" });

  try {
    const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}&key=${process.env.API_KEY}`);
    
    if (!response.ok) {
        const errorText = await response.text();
        console.error("Google API Error:", errorText);
        return res.status(response.status).json({ error: "Google API rejected the request" });
    }

    const data = await response.json();
    res.json(data);
} catch (err) {
    console.error("Server Error:", err.message);
    res.status(500).json({ error: err.message });
}
});


app.listen(3000, () => console.log('Server running'));

const form = document.getElementById("addBookForm");
const output = document.getElementById("output");

// Function to handle form submission
form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(form);
  const data = {};
  formData.forEach((value, key) => {
    data[key] = value;
  });

  try {
    const response = await fetch("api.php", {
      method: "POST",
      body: JSON.stringify(data),
      headers: {
        "Content-Type": "application/json",
      },
    });
    const result = await response.json();
    if (response.ok) {
      output.innerHTML = "<p>Data buku berhasil ditambahkan.</p>";
      form.reset();
    } else {
      output.innerHTML = `<p id="error">${result.error}</p>`;
    }
  } catch (error) {
    output.innerHTML = `<p id="error">Terjadi kesalahan: ${error.message}</p>`;
  }
});

// Function to fetch and display data
async function fetchData() {
  try {
    const response = await fetch("api.php");
    const data = await response.json();
    let html = "<h2>Daftar Buku</h2>";
    html += "<ul>";
    data.forEach((book) => {
      html += `<li>${book.judul_buku} - ${book.jumlah} - Rp ${book.harga}</li>`;
    });
    html += "</ul>";
    output.innerHTML = html;
  } catch (error) {
    output.innerHTML = `<p id="error">Terjadi kesalahan: ${error.message}</p>`;
  }
}

// Fetch and display data when the page loads
fetchData();

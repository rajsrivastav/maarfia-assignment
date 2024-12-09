<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Blog Search</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container py-4">
    <h1 class="text-center mb-4">PHP Blog/Text Search</h1>
    
    <!-- Search form -->
    <form id="searchForm" class="mb-3">
      <div class="input-group">
        <input type="text" id="searchQuery" class="form-control" placeholder="Search for blogs..." required>
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>

    <!-- Filter -->
    <div class="mb-3">
      <label for="filterCategory" class="form-label">Filter by category:</label>
      <select id="filterCategory" class="form-select">
        <option value="">All Categories</option>
        <option value="tech">Tech</option>
        <option value="lifestyle">Lifestyle</option>
        <option value="business">Business</option>
      </select>
    </div>

    <!-- Results -->
    <div id="results" class="mt-4">
      <p class="text-muted">No results found. Try searching for something!</p>
    </div>
  </div>

  <script>
    const searchForm = document.getElementById('searchForm');
    const searchQuery = document.getElementById('searchQuery');
    const filterCategory = document.getElementById('filterCategory');
    const resultsDiv = document.getElementById('results');

    searchForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const query = searchQuery.value;
      const category = filterCategory.value;

      fetch(`search.php?query=${encodeURIComponent(query)}&category=${encodeURIComponent(category)}`)
        .then(response => response.json())
        .then(data => {
          displayResults(data);
        })
        .catch(error => {
          console.error('Error fetching results:', error);
          resultsDiv.innerHTML = '<p class="text-danger">An error occurred while fetching results.</p>';
        });
    });

    function displayResults(results) {
      if (results.length === 0) {
        resultsDiv.innerHTML = '<p class="text-danger">No results found.</p>';
      } else {
        resultsDiv.innerHTML = results.map(blog => `
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title">${blog.title}</h5>
              <p class="card-text">${blog.content}</p>
              <span class="badge bg-secondary">${blog.category}</span>
            </div>
          </div>
        `).join('');
      }
    }
  </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')

    <style type="text/css">
      .div_center {
        text-align: center;
        padding-top: 40px;
      }

      .font_size {
        font-size: 40px;
        padding-bottom: 40px;
      }

      .text_color {
        color: black;
        padding-bottom: 20px;
      }

      label {
        display: inline-block;
        width: 200px;
      }

      .div_design {
        padding-bottom: 15px;
      }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.sidebar')
      @include('admin.header')
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="div_center">
            <h1 class="font_size">Add Product</h1>

            <form id="addProductForm" enctype="multipart/form-data">
              @csrf

              <div class="div_design">
                <label>Product Title :</label>
                <input class="text_color" type="text" name="title" id="title" placeholder="Write a title" required="">
              </div>

              <div class="div_design">
                <label>Product Description :</label>
                <input class="text_color" type="text" name="description" id="description" placeholder="Write a description" required="">
              </div>

              <div class="div_design">
                <label>Product Price :</label>
                <input class="text_color" type="number" name="price" id="price" placeholder="Write a price" required="">
              </div>

              <div class="div_design">
                <label>Discount Price :</label>
                <input class="text_color" type="number" name="dis_price" id="dis_price" placeholder="Write a discount price">
              </div>

              <div class="div_design">
                <label>Product Quantity :</label>
                <input class="text_color" type="number" min="0" name="quantity" id="quantity" placeholder="Write a quantity" required="">
              </div>

              <div class="div_design">
                <label>Product Category :</label>
                <select class="text_color" name="catagory" id="catagory" required="">
                  <option value="" selected="">Add a category here</option>
                  @foreach($catagory as $cat)
                    <option value="{{ $cat->catagory_name }}">{{ $cat->catagory_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="div_design">
                <label>Product Image Here :</label>
                <input type="file" name="image" id="image" required="">
              </div>

              <div class="div_design">
                <input type="submit" value="Add Product" class="btn btn-primary">
              </div>
            </form>

            <h1 class="font_size">Search Products</h1>
            <div class="div_design">
              <input class="text_color" type="text" id="searchText" placeholder="Search for a product">
            </div>

            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th>Quantity</th>
                  <th>Category</th>
                  <th>Image</th>
                </tr>
              </thead>
              <tbody id="productTableBody">
                <!-- Products will be dynamically loaded here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    @include('admin.script')

    <script>
      // CSRF Token for AJAX
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Add Product using AJAX
      $('#addProductForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
          type: 'POST',
          url: '{{ url("/ajax-add-product") }}',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            alert(response.message);
            $('#addProductForm')[0].reset();
            loadProducts(); // Refresh product table
          },
          error: function(error) {
            console.error(error);
            alert('Error adding product!');
          }
        });
      });

      // Search Products using AJAX
      $('#searchText').on('keyup', function() {
        let query = $(this).val();

        $.ajax({
          type: 'GET',
          url: '{{ url("/ajax-search-product") }}',
          data: { search: query },
          success: function(response) {
            let rows = '';
            response.products.forEach(product => {
              rows += `
                <tr>
                  <td>${product.id}</td>
                  <td>${product.title}</td>
                  <td>${product.description}</td>
                  <td>${product.price}</td>
                  <td>${product.discount_price}</td>
                  <td>${product.quantity}</td>
                  <td>${product.catagory}</td>
                  <td><img src="/product/${product.image}" alt="Product Image" width="50"></td>
                </tr>
              `;
            });
            $('#productTableBody').html(rows);
          },
          error: function(error) {
            console.error(error);
            alert('Error fetching products!');
          }
        });
      });

      // Load Products
      function loadProducts() {
        $('#searchText').trigger('keyup');
      }

      // Initial Load
      loadProducts();
    </script>
  </body>
</html>

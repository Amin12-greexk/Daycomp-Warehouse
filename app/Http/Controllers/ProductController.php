<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Shelf;
use App\Models\Rack;
use App\Models\Supplier;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('supplier')->get();  // Eager load supplier data
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $racks = Rack::all();
        $shelves = Shelf::all();
        $suppliers = Supplier::all();  // Get all suppliers
        
        return view('products.create', compact('categories','racks', 'shelves', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|unique:products|max:255',  // Ensure product code is unique and required
'product_name' => 'required',  // Ensure product name is required
'category_id' => 'required|exists:categories,id',  // Ensure category exists in the categories table  // Ensure supplier exists in the suppliers table
'warehouse_id' => 'required|exists:warehouses,id',  // Ensure warehouse exists in the warehouses table
'shelf_id' => 'required|exists:shelves,id',  // Ensure shelf exists in the shelves table
'rack_id' => 'required|exists:racks,id',  // Ensure rack exists in the racks table
'purchase_price' => 'required|numeric',  // Ensure purchase price is numeric
'sale_price' => 'required|numeric',  // Ensure sale price is numeric
'product_date' => 'required|date',  // Ensure product date is a valid date
'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Ensure image is valid if provided

        ]);

        $warehouse = Warehouse::find($validated['warehouse_id']);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        // Store the product with supplier_id
        Product::create([
            'product_code' => $validated['product_code'],
            'product_name' => $validated['product_name'],
            'category_id' => $validated['category_id'],  // Save supplier_id
            'warehouse_id' => $validated['warehouse_id'],
            'warehouse_name' => $warehouse->warehouse_name,
            'purchase_price' => $validated['purchase_price'],
            'sale_price' => $validated['sale_price'],
            'date_in' => $validated['product_date'],
            'image' => $imagePath,
            'rack_id' => $request->rack_id,
            'shelf_id' => $request->shelf_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $racks = Rack::all();
        $shelves = Shelf::all();
        $suppliers = Supplier::all();  // Get all suppliers
        
        return view('products.edit', compact('product', 'categories', 'racks', 'shelves', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_code' => 'required|max:255',
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',  // Add supplier_id validation
            'rack_id' => 'required|exists:racks,id',
            'shelf_id' => 'required|exists:shelves,id',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'date_in' => 'required|date',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'product_code' => $validated['product_code'],
            'product_name' => $validated['product_name'],
            'category_id' => $validated['category_id'],
            'supplier_id' => $validated['supplier_id'],  // Update supplier_id
            'rack_id' => $validated['rack_id'],
            'shelf_id' => $validated['shelf_id'],
            'purchase_price' => $validated['purchase_price'],
            'sale_price' => $validated['sale_price'],
            'date_in' => $validated['date_in'],
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function showQrCode($id)
    {
        $product = Product::with('warehouse', 'stock', 'supplier')->findOrFail($id);
        $category = Category::find($product->category_id);
        $warehouseName = $product->warehouse->warehouse_name ?? 'N/A';

        // Prepare the product details as text
        $productDetails = "Product Name: " . $product->product_name . "\n" .
                          "Product Code: " . $product->product_code . "\n" .
                          "Category: " . ($category ? $category->category_name : 'N/A') . "\n" .
                          "Warehouse: " . $warehouseName . "\n" .
                          "Stock Quantity: " . ($product->stock->quantity ?? '0') . "\n" .
                          "Purchase Price: Rp " . number_format($product->purchase_price, 0, ',', '.') . "\n" .
                          "Sale Price: Rp " . number_format($product->sale_price, 0, ',', '.') . "\n" .
                          "Date Added: " . $product->created_at->format('d M Y') . "\n" .
                          "Supplier: " . $product->supplier->name ?? 'N/A';

        // Generate QR code with product details
        $qrCode = QrCode::size(300)->generate($productDetails);

        return view('products.qrcode', compact('product', 'qrCode'));
    }

    public function showDetails($id)
    {
        $product = Product::with('category', 'warehouse', 'stock', 'supplier')->findOrFail($id);
        return view('products.details', compact('product'));
    }
    
    // Supplier Methods (same as before)
    public function indexSuppliers()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function createSupplier()
    {
        return view('suppliers.create');
    }

    public function storeSupplier(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        Supplier::create([
            'name' => $validated['name'],
            'contact_info' => $validated['contact_info'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully!');
    }

    public function editSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function updateSupplier(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'name' => $validated['name'],
            'contact_info' => $validated['contact_info'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully!');
    }

    public function destroySupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Inventory\CategoryRequest;
use App\Models\Inventory\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->with('parent')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.inventory.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $category = new Category();
        $parents = Category::query()->orderBy('name')->pluck('name', 'id');

        return view('admin.inventory.categories.create', compact('category', 'parents'));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        Category::create($data);

        return redirect()
            ->route('admin.inventory.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        $category->load('parent', 'children', 'items');

        return view('admin.inventory.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        $parents = Category::query()
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('admin.inventory.categories.edit', compact('category', 'parents'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $category->update($data);

        return redirect()
            ->route('admin.inventory.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.inventory.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}

<div class="table-responsive">
    <table class="table table-hover border-bottom mb-0 text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center align-middle">
                    <input type="checkbox" id="checkAll">
                </th>
                <th style="width: 60px;" class="align-middle">Image</th>
                <th class="align-middle">Product Name</th>
                <th class="align-middle">Category</th>
                <th class="align-middle">SKU</th>
                <th class="text-center align-middle">Featured</th>
                <th class="text-center align-middle">Status</th>
                <th style="width: 150px;" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody id="sortable-tbody">
            @forelse($products as $product)
                <tr data-id="{{ $product->id }}" class="{{ !($isTrash ?? false) ? 'sortable-row' : '' }}">
                    <td class="text-center align-middle" onclick="event.stopPropagation();">
                        <input type="checkbox" class="row-checkbox" value="{{ $product->id }}">
                    </td>
                    <td class="align-middle">
                        <img src="{{ $product->featured_image_url ?: asset('images/no-image.png') }}" class="border rounded" width="40" height="30" style="object-fit: contain;">
                    </td>
                    <td class="align-middle font-weight-bold text-dark">
                        {{ $product->name }}
                    </td>
                    <td class="align-middle text-muted">
                        {{ $product->category->name ?? 'N/A' }}
                    </td>
                    <td class="align-middle text-muted">
                        {{ $product->sku ?: 'N/A' }}
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $product->is_featured ? 'warning' : 'light' }}">
                            {{ $product->is_featured ? 'Featured' : 'Standard' }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $product->status ? 'success' : 'secondary' }}">
                            {{ $product->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        @if($isTrash ?? false)
                            @canany(['product_restore', 'product_manage'])
                                <button type="button" class="btn btn-sm btn-outline-success btn-restore shadow-sm mx-1" data-url="{{ route('admin.products.restore', $product->id) }}" title="Restore"><i class="fas fa-undo"></i></button>
                            @endcanany
                            @canany(['product_force_delete', 'product_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-force-delete shadow-sm mx-1" data-url="{{ route('admin.products.force_delete', $product->id) }}" title="Permanent Delete"><i class="fas fa-trash-alt"></i></button>
                            @endcanany
                        @else
                            @canany(['product_view', 'product_manage'])
                                <button type="button" class="btn btn-sm btn-outline-info btn-show shadow-sm mx-1" data-url="{{ route('admin.products.show', $product->id) }}" title="View"><i class="fas fa-eye"></i></button>
                            @endcanany
                            @canany(['product_update', 'product_manage'])
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit shadow-sm mx-1" data-url="{{ route('admin.products.edit', $product->id) }}" title="Edit"><i class="fas fa-pen"></i></button>
                            @endcanany
                            @canany(['product_delete', 'product_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete shadow-sm mx-1" data-url="{{ route('admin.products.destroy', $product->id) }}" title="Trash"><i class="fas fa-trash"></i></button>
                            @endcanany
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-box fa-3x mb-3 text-light"></i>
                            <h5 class="font-weight-bold">No Products Found</h5>
                            <p class="mb-0 small">No data available in this section.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($products->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3 py-3 border-top bg-light">
        <div class="text-muted small font-weight-bold mb-2 mb-md-0">
            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} entries
        </div>
        <div class="m-0 pagination-sm">
            {!! $products->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endif
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        const $page = $('#page-manager');
        const $wrapper = $('#content-wrapper');

        function loadData(url = $page.data('index-url')) {
            $wrapper.addClass('loading');
            let params = {
                search: $('#table_search').val(),
                guard_name: $('#filter_guard').length ? $('#filter_guard').val() : ''
            };

            $.get(url, params, function(res) {
                $wrapper.html(res.html).removeClass('loading');
                $('#checkAll').prop('checked', false);
            }).fail(function() {
                $wrapper.removeClass('loading');
                Swal.fire('Error', 'Failed to load data.', 'error');
            });
        }

        $(document).on('click', '#btnSearch', function() { loadData(); });
        $(document).on('change', '#filter_guard', function() { loadData(); });
        $(document).on('keypress', '#table_search', function(e) { if(e.which === 13) { e.preventDefault(); loadData(); } });

        $(document).on('click', '#btnClearSearch', function() {
            $('#table_search').val('');
            loadData();
        });

        $(document).on('click', '#btnResetFilter', function() {
            $('#table_search').val('');
            if ($('#filter_guard').length) $('#filter_guard').val('');
            loadData();
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            loadData($(this).attr('href'));
        });

        function openModal(url, title) {
            $('#modal-title').text(title);
            $('#modal-body').html('<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i><p class="font-weight-bold text-muted">Loading...</p></div>');
            $('#ajaxModal').modal('show');

            $.get(url, function(res) {
                $('#modal-body').html(res.html);
            }).fail(function() {
                $('#modal-body').html('<div class="alert alert-danger m-3">Failed to load content!</div>');
            });
        }

        $(document).on('click', '#btnAddRecord', function() {
            let createUrl = $page.data('create-url');
            if(createUrl) openModal(createUrl, 'Create New Role');
        });

        $(document).on('click', '.btn-edit', function() {
            let url = $(this).data('url');
            if(url) openModal(url, 'Edit Role');
        });

        $(document).on('click', '.btn-show', function() {
            let url = $(this).data('url');
            if(url) openModal(url, 'Role Details');
        });

        // Fetch Permissions via AJAX (Guard or Search change)
        function fetchPermissions() {
            let guardName = $('#guard_name').val();
            let search = $('#permission_search').val();
            let roleId = $('#ajax-form').data('role-id');

            let url = "{{ route('admin.roles.get_permissions') }}";

            $('#permissions-container').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i></div>');

            $.get(url, {
                guard_name: guardName,
                search: search,
                role_id: roleId
            }, function(res) {
                if(res.success) {
                    $('#permissions-container').html(res.html);
                }
            });
        }

        // Guard change event
        $(document).on('change', '#guard_name', function() {
            fetchPermissions();
        });

        // Server-side Permission search event (with debounce feel or direct)
        let searchTimer;
        $(document).on('keyup', '#permission_search', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                fetchPermissions();
            }, 300);
        });

        // Select All / Deselect All Permissions
        $(document).on('click', '#btnSelectAll', function() {
            $('.permission-checkbox:visible').prop('checked', true);
            $('.group-select-all').prop('checked', true);
        });

        $(document).on('click', '#btnDeselectAll', function() {
            $('.permission-checkbox').prop('checked', false);
            $('.group-select-all').prop('checked', false);
        });

        // Check/Uncheck Group Select All based on individual checkboxes
        $(document).on('change', '.permission-checkbox', function() {
            let $card = $(this).closest('.permission-group-card');
            let total = $card.find('.permission-checkbox').length;
            let checked = $card.find('.permission-checkbox:checked').length;

            $card.find('.group-select-all').prop('checked', total === checked);
        });

        // Group Select All Action
        $(document).on('change', '.group-select-all', function() {
            let $cardBody = $(this).closest('.card').find('.card-body');
            $cardBody.find('.permission-checkbox').prop('checked', this.checked);
        });

        // AJAX Form Submit (Store & Update)
        $(document).on('submit', '#ajax-form', function(e) {
            e.preventDefault();
            let $form = $(this);
            let $btn = $form.find('button[type="submit"]');
            let formData = new FormData(this);

            $btn.prop('disabled', true).append(' <i class="fas fa-spinner fa-spin ml-1"></i>');
            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#ajaxModal').modal('hide');
                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 3000 });
                    loadData();
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).find('.fa-spinner').remove();
                    if(xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function(field, err) {
                            let fieldName = field.replace('.', '_');
                            $(`[name="${field}"]`).addClass('is-invalid');
                            $(`.error-${fieldName}`).text(err[0]).show();
                        });
                    } else if(xhr.responseJSON && xhr.responseJSON.message) {
                        Swal.fire('Error', xhr.responseJSON.message, 'error');
                    } else {
                        Swal.fire('Error', 'An unexpected error occurred.', 'error');
                    }
                }
            });
        });

        // Delete, Restore, Force Delete Single Item
        $(document).on('click', '.btn-delete, .btn-restore, .btn-force-delete', function() {
            let url = $(this).data('url');
            if(!url) return;

            let isForce = $(this).hasClass('btn-force-delete');
            let method = $(this).hasClass('btn-restore') ? 'POST' : 'DELETE';

            Swal.fire({
                title: isForce ? 'Permanently Delete?' : 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((res) => {
                if (res.value) {
                    $.ajax({
                        url: url,
                        type: method,
                        success: function(res) {
                            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 3000 });
                            loadData();
                        },
                        error: function(xhr) {
                            let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Action failed.';
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                }
            });
        });

        // Bulk Selection Check All
        $(document).on('click', '#checkAll', function() {
            $('.row-checkbox').prop('checked', this.checked);
        });

        // Apply Bulk Action
        $(document).on('click', '#btnApplyBulk', function() {
            let action = $('#bulk_action').val();
            let ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();

            if (!action) return Swal.fire('Notice', 'Please select a bulk action.', 'info');
            if (ids.length === 0) return Swal.fire('Notice', 'Please select at least one row.', 'info');

            Swal.fire({
                title: 'Confirm Bulk Action',
                text: `Apply this action on ${ids.length} item(s)?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Proceed'
            }).then((result) => {
                if (result.value) {
                    let bulkUrl = $page.data('bulk-url');
                    $.post(bulkUrl, { action: action, ids: ids }, function(res) {
                        if(res.success) {
                            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 3000 });
                            $('#bulk_action').val('');
                            loadData();
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    }).fail(function(xhr) {
                        let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Bulk action failed.';
                        Swal.fire('Error', msg, 'error');
                    });
                }
            });
        });
    });
</script>

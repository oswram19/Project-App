@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>Categorías</h1>
@stop

@section('content')
    <div class="card mb-2">
        <div class="card-body py-2">
            <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
                <span class="mr-2 text-muted" id="selectedCategoryLabel">
                    <i class="fas fa-tag mr-1"></i> Ninguna categoría seleccionada
                </span>
                <div class="ml-auto d-flex flex-wrap" style="gap:6px;">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-action btn-create btn-sm">
                        <i class="fas fa-plus"></i> Nueva Categoría
                    </a>
                    <a id="btnEditarCategoria" href="#" class="btn btn-sm btn-action btn-edit disabled" aria-disabled="true">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <button id="btnEliminarCategoria" type="button" class="btn btn-sm btn-action btn-delete" disabled>
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Categorías</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="categories">
                <thead>
                    <tr>
                        <th style="width:30px;"></th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                    </tr>
                </thead>
            </table>

            <form id="deleteCategoryForm" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

            <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteCategoryModalLabel">Confirmar Eliminación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de eliminar la categoría <span id="categoryNameSpan"></span>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteCategoryBtn">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contactanos-splashed is-empty" id="categoriesSplashed">
        <div class="toast-panel">
            <div class="toast-item" id="categoriesToastItem">
                <div class="toast success" id="categoriesToastBox">
                    <label class="close" id="categoriesToastClose"></label>
                    <h3 id="categoriesToastTitle">Éxito</h3>
                    <p id="categoriesToastMessage">Operación completada correctamente.</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}?v={{ filemtime(public_path('css/admin-custom.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/contactanos.css') }}?v={{ filemtime(public_path('css/contactanos.css')) }}">
    <style>
        #categories tbody tr { cursor: pointer; }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.7/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.7/js/responsive.bootstrap4.js"></script>

    <script>
        let selectedCategory = { id: null, name: '' };
        const categoriesToastContainer = document.getElementById('categoriesSplashed');
        const categoriesToastBox = document.getElementById('categoriesToastBox');
        const categoriesToastTitle = document.getElementById('categoriesToastTitle');
        const categoriesToastMessage = document.getElementById('categoriesToastMessage');
        const categoriesToastClose = document.getElementById('categoriesToastClose');
        let categoriesToastTimer = null;

        function hideCategoriesToast() {
            if (categoriesToastTimer) {
                clearTimeout(categoriesToastTimer);
                categoriesToastTimer = null;
            }

            if (categoriesToastContainer) {
                categoriesToastContainer.classList.add('is-empty');
            }
        }

        function showCategoriesToast(type, title, message) {
            if (!categoriesToastContainer || !categoriesToastBox) return;

            const normalizedType = ['success', 'warning', 'error', 'help', 'info'].includes(type) ? type : 'success';
            categoriesToastBox.classList.remove('help', 'info', 'success', 'warning', 'error');
            categoriesToastBox.classList.add(normalizedType);

            if (categoriesToastTitle) {
                categoriesToastTitle.textContent = title || 'Notificación';
            }

            if (categoriesToastMessage) {
                categoriesToastMessage.textContent = message || '';
            }

            if (categoriesToastTimer) {
                clearTimeout(categoriesToastTimer);
            }

            categoriesToastContainer.classList.remove('is-empty');
            categoriesToastTimer = setTimeout(hideCategoriesToast, 4500);
        }

        if (categoriesToastClose) {
            categoriesToastClose.addEventListener('click', function() {
                hideCategoriesToast();
            });
        }

        function updateCategoryActionButtons() {
            const hasSelection = selectedCategory.id !== null;
            const label = document.getElementById('selectedCategoryLabel');

            if (hasSelection) {
                label.innerHTML = `<i class="fas fa-check-circle mr-1 text-success"></i> <strong>${selectedCategory.name}</strong> seleccionada`;
                $('#btnEditarCategoria').removeClass('disabled').attr('aria-disabled', 'false')
                    .attr('href', `/admin/categories/${selectedCategory.id}/edit`);
                $('#btnEliminarCategoria').prop('disabled', false);
            } else {
                label.innerHTML = `<i class="fas fa-tag mr-1"></i> Ninguna categoría seleccionada`;
                $('#btnEditarCategoria').addClass('disabled').attr('aria-disabled', 'true').attr('href', '#');
                $('#btnEliminarCategoria').prop('disabled', true);
            }
        }

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            updateCategoryActionButtons();

            @if(session('deleted'))
                showCategoriesToast('error', 'Eliminado', @json(session('deleted')));
            @elseif(session('created'))
                showCategoriesToast('success', 'Creado', @json(session('created')));
            @elseif(session('updated'))
                showCategoriesToast('info', 'Actualizado', @json(session('updated')));
            @elseif(session('warning'))
                showCategoriesToast('warning', 'Advertencia', @json(session('warning')));
            @elseif(session('error'))
                showCategoriesToast('error', 'Error', @json(session('error')));
            @elseif(session('success'))
                showCategoriesToast('success', 'Éxito', @json(session('success')));
            @endif

            $('#btnEditarCategoria').on('click', function(e) {
                if ($(this).attr('aria-disabled') === 'true') {
                    e.preventDefault();
                }
            });

            $('#btnEliminarCategoria').on('click', function() {
                if (!selectedCategory.id) return;

                document.getElementById('categoryNameSpan').textContent = selectedCategory.name;
                $('#deleteCategoryModal').modal('show');
            });

            document.getElementById('confirmDeleteCategoryBtn').addEventListener('click', function() {
                if (!selectedCategory.id) return;

                const form = document.getElementById('deleteCategoryForm');
                form.action = `/admin/categories/${selectedCategory.id}`;
                $('#deleteCategoryModal').modal('hide');
                form.submit();
            });
        });

        new DataTable('#categories', {
            ajax: '/datatable/categories',
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<input type="radio" name="categorySelect" class="category-radio" value="${row.id}"
                                    data-name="${String(row.name).replace(/"/g, '&quot;')}" style="cursor:pointer;">`;
                    }
                },
                { data: 'id' },
                { data: 'name' },
                { data: 'description' },
                { data: 'created_at' }
            ],
            responsive: true,
            autoWidth: true,
            language: {
                "lengthMenu": "Mostrar" +
                    '<select class="custom-select custom-select-sm form-control form-control-sm">' +
                    '<option value="5">5</option>' +
                    '<option value="10">10</option>' +
                    '<option value="25">25</option>' +
                    '<option value="50">50</option>' +
                    '<option value="100">100</option>' +
                    '<option value="-1">todos</option>' +
                    '</select>' +
                    "registros por página",
                "zeroRecords": "No se encontró registro - Busca nuevamente",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                search: "Buscar:",
                paginate: {
                    next: "Siguiente",
                    previous: "Anterior"
                }
            },
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();

                if (selectedCategory.id !== null) {
                    $(`input.category-radio[value="${selectedCategory.id}"]`).prop('checked', true)
                        .closest('tr').addClass('table-active');
                }
            }
        });

        $(document).on('click', '#categories tbody tr', function() {
            const radio = $(this).find('input.category-radio');

            if (radio.length) {
                radio.prop('checked', true);
                $('#categories tbody tr').removeClass('table-active');
                $(this).addClass('table-active');

                selectedCategory.id = radio.val();
                selectedCategory.name = radio.data('name');
                updateCategoryActionButtons();
            }
        });
    </script>
@stop

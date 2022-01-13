@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Пункты меню</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ config('admin.path').'/menu/create' }}" class="btn btn-sm btn-outline-dark">
                Создать пункт
            </a>
        </div>
    </div>

    @if(count($success) > 0)
        @foreach($success as $value)
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
        @endforeach
    @endif

    @if(count($errors) > 0)
        @foreach($errors as $error)
            <div class="alert alert-danger text-center" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if(count($menu) > 0)
        <table class="table table-hover table-bordered">
            <thead class="table-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Ссылка</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
                @foreach($menu as $item)
                    <tr>
                        <td>
                            {{ $item['id'] }}
                        </td>
                        <td>
                            {{ $item['title'] }}
                        </td>
                        <td>
                            {{ $item['link'] }}
                        </td>
                        <td>
                            <a class="btn edit-icon" href="{{ config('admin.path').'/menu/'.$item['id'] }}" title="Редактировать">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>
                            <form class="delete-btn-wrap" method="POST" action="{{ config('admin.path').'/menu/delete/'.$item['id'] }}">
                                <button type="submit" class="btn delete-icon" title="Удалить">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(!$menu)
        <p>Пунктов меню не найдено</p>
    @endif
@endsection
{{-- Inside partials/employees_list.blade.php --}}
@php $i = 1; @endphp
@foreach ($employees as $employee)
<tr>
    <td> {{ $i++ }} </td>
    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
    <td>{{ $employee->company->name ?? 'N/A' }}</td>
    <td>{{ $employee->email }}</td>
    <td>{{ $employee->phone }}</td>
    <td>
        <button class="btn btn-secondary edit-button" data-employee-id="{{ $employee->id }}"
                data-toggle="modal" data-target="#editEmployeeModal">Edit</button>
        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
              onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </td>
</tr>
@endforeach

@extends('monkyz::layouts.monkyz')

@section('content')
	<div class="row">
		<div class="col-md-12">
			@php
				$htables = new Lab1353\Monkyz\Helpers\TablesHelper();
				$key = $htables->findKeyFieldName($section);
			@endphp
			<div class="card">
				<div class="content">
					<div class="toolbar">
						<!--Here you can write extra buttons/actions for the toolbar-->
					</div>
					<div class="fresh-datatables">
						<table id="datatables" class="table table-striped table-no-bordered table-hover">
							<thead>
								<tr>
									@foreach($fields as $field=>$params)
										@if($params['in_list'])
											<th>{{ $params['title'] }}</th>
										@endif
									@endforeach
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($records as $record)
									<tr>
										@foreach($fields as $field=>$params)
											@if($params['in_list'])
												{!! Lab1353\Monkyz\Helpers\FieldsHelper::renderInList($params, $record[$field]) !!}
											@endif
										@endforeach
										<td align="right">
											<a href="{{ route('monkyz.dynamic.edit', [ 'id'=>$record[$key], 'section'=>$section ]) }}" class="btn btn-sm btn-fill btn-primary"><i class="fa fa-pencil"></i>Edit</a>
											<a href="{{ route('monkyz.dynamic.delete', [ 'id'=>$record[$key], 'section'=>$section ]) }}" class="btn btn-sm btn-fill btn-danger btn-delete-record"><i class="fa fa-trash"></i>Delete</a>
										</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot></tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
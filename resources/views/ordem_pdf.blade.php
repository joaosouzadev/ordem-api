<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/home/joao/Documents/os-api/public/css/bootstrap.min.css">
	<title>PDF</title>
	<style>
		.border {
			box-shadow: 
			    2px 1px 0 1px #888,
		}
	</style>
</head>
<body style="margin: 0 5px">
	<div class="row" style="padding: 5px; padding-bottom: 20px; border-bottom: 2px solid #ddd">
		<div class="col-2 offset-2">
			<img src="/home/joao/Documents/os-api/public/img/LOGO.png" style="width: 50%; margin-top: 25px;">
		</div>
		<div class="col-8" style="padding-left: 0">
			<img src="/home/joao/Documents/os-api/public/img/LOGO2.png" style="width: 60%; margin-top: 40px">
		</div>
	</div>

	<table class="table table-bordered" style="margin-top: 30px">
		<thead>
			<th style="text-align: ; width: 90%; border-right: 0; font-size: 22px">ORDEM DE SERVIÇO Nº 001</th>
			<th style="text-align: right; border-left: 0; font-size: 22px">{{ $ordem->data_entrada->format('d/m/Y') }}</th>
		</thead>
		<tbody>
			<tr>
				<td colspan="2">{{ $ordem->situacao }}</td>
			</tr>
		</tbody>
	</table>

	<table class="table table-bordered">
		<thead>
			<th colspan="4">Dados do Cliente</th>
		</thead>
		<tbody>
			<tr>
				<td><b>Cliente</b></td>
				<td>{{ $ordem->cliente->nome }}</td>
				<td><b>Email</b></td>
				<td>{{ $ordem->cliente->email }}</td>
			</tr>
			<tr>
				<td><b>Telefone</b></td>
				<td>{{ $ordem->cliente->telefone }}</td>
				<td><b>Celular</b></td>
				<td>{{ $ordem->cliente->celular }}</td>
			</tr>
		</tbody>
	</table>

	<table class="table table-bordered">
		<thead>
			<th colspan="8">Dados do Equipamento</th>
		</thead>
		<tbody>
			<tr>
				<td><b>Equipamento</b></td>
				<td>{{ $ordem->equipamento }}</td>
				<td><b>Marca</b></td>
				<td>{{ $ordem->marca }}</td>
				<td><b>Modelo</b></td>
				<td>{{ $ordem->modelo }}</td>
				<td><b>Nº Série</b></td>
				<td>{{ $ordem->numero_serie }}</td>
			</tr>
		</tbody>
	</table>

	<table class="table table-bordered">
		<thead>
			<th colspan="2">Serviços</th>
		</thead>
		<tbody>
			@foreach(json_decode($ordem->servicos) as $servico)
			<tr>
			    <td colspan="2">{{ $servico }}</td>
			</tr>
			@endforeach
			<tr>
			    <td style="width: 10%"><b>Total</b></td>
			    <td style="text-align: right">R$ {{ number_format($ordem->valor, 2, ',', '.') }}</td>
			</tr>
		</tbody>
	</table>

	<table class="table table-bordered">
		<thead>
			<th>Observações</th>
		</thead>
		<tbody>
			<tr>
				<td>{{ $ordem->observacoes }}</td>
			</tr>
		</tbody>
	</table>

	<table class="table table-bordered">
		<thead>
			<th style="padding-bottom: 50px">Assinatura Cliente</th>
			<th style="padding-bottom: 50px">Assinatura Empresa</th>
		</thead>
	</table>
</body>
</html>
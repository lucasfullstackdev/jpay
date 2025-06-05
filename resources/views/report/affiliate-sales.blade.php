<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatório de Vendas</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      padding: 8px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    .summary {
      margin-top: 20px;
      padding-top: 10px;
      border-top: 2px solid #ccc;
    }

    .summary p {
      margin: 5px 0;
    }

    .footer {
      margin-top: 20px;
      padding-top: 10px;
      border-top: 2px solid #ccc;
      font-size: 12px;
      color: #999;
    }

    /* Style for unpaid rows */
    .unpaid {
      background-color: #ffcccc;
      /* Light red */
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Relatório de Vendas</h2>

    <p>Olá <strong>{{ $affiliateSales->affiliate->name }}</strong>,</p>

    <p>Aqui está o resumo das suas vendas:</p>

    <table>
      <thead>
        <tr>
          <th>Valor</th>
          <th>Voucher</th>
          <th>Percentual do Afiliado</th>
          <th>Comissão</th>
          <th>Pagamento Reconhecido?</th>
        </tr>
      </thead>
      <tbody>
        @foreach($affiliateSales->billings as $billing)
        <tr class="{{ $billing->payment->paid ? '' : 'unpaid' }}">
          <td>R$ {{ number_format($billing->payment->value, 2, ',', '.') }}</td>
          <td>{{ $billing->payment->voucher }}</td>
          <td style="text-align: center;">{{ $billing->payment->commission->percentage }}%</td>
          <td style="text-align: center;">R$ {{ number_format($billing->payment->commission->value, 2, ',', '.') }}</td>
          <td style="text-align: center;">{{ $billing->payment->paid ? 'Sim' : 'Não' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="summary">
      <p><strong>Total de Vendas:</strong> {{ $affiliateSales->quantity_of_billings }}</p>
      <p><strong>Valor Total:</strong> R$ {{ number_format($affiliateSales->total_sales, 2, ',', '.') }}</p>
      <p><strong>Comissão Total:</strong> R$ {{ number_format($affiliateSales->total_commission, 2, ',', '.') }}</p>
    </div>

    <p><strong>Este relatório é uma representação estatística das suas vendas e está sujeito a possíveis variações e inconsistências. Apenas são considerados os vouchers válidos e atrelados ao seu perfil de afiliado.</strong></p>

    <p>Obrigado por ser um afiliado conosco!</p>

    <div class="footer">
      <p>Este e-mail foi enviado automaticamente. Por favor, não responda. Esta funcionalidade está em fase de testes.</p>
    </div>
  </div>
</body>

</html>
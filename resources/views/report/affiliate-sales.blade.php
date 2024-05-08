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
  </style>
</head>

<body>
  <div class="container">
    <h2>Relatório de Vendas</h2>

    <p>Olá {{ $affiliateSales['affiliate']['name'] }},</p>

    <p>Aqui está o resumo das suas vendas durante o período de {{ $affiliateSales['report']['initial_date'] }} a {{ $affiliateSales['report']['final_date'] }}:</p>

    <table>
      <thead>
        <tr>
          <th>Data</th>
          <th>Valor</th>
          <th>Voucher</th>
          <th>Percentual do Afiliado</th>
          <th>Comissão</th>
        </tr>
      </thead>
      <tbody>
        @foreach($affiliateSales['subscriptions'] as $subscription)
        <tr>
          <td>{{ $subscription['date'] }}</td>
          <td>R$ {{ number_format($subscription['value'], 2, ',', '.') }}</td>
          <td>{{ $subscription['voucher']['code'] }}</td>
          <td style="text-align: center;">{{ $subscription['voucher']['affiliate_percentage'] }} %</td>
          <td style="text-align: center;">R$ {{ number_format($subscription['voucher']['commission'], 2, ',', '.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="summary">
      <p>Total de Vendas: {{ $affiliateSales['quantity'] }}</p>
      <p>Valor Total: R$ {{ number_format($affiliateSales['total_value'], 2, ',', '.') }}</p>
      <p>Comissão Total: R$ {{ number_format($affiliateSales['total_commission'], 2, ',', '.') }}</p>
    </div>

    <p><strong>Este relatório é uma representação estatística das suas vendas durante o período de {{ $affiliateSales['report']['initial_date'] }} a {{ $affiliateSales['report']['final_date'] }} e está sujeito a possíveis variações e inconsistências. Apenas são considerados os vouchers válidos e atrelados ao seu perfil de afiliado.</strong></p>

    <p>Obrigado por ser um afiliado conosco!</p>

    <div class="footer">
      <p>Este e-mail foi enviado automaticamente. Por favor, não responda. Esta funcionalidade está em fase de testes.</p>
    </div>
  </div>
</body>

</html>
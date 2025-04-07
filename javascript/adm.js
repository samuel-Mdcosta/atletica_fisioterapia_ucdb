$(document).ready(function(){
    $(".toggleButton").click(function(){
        var userId = $(this).data("id");
        var button = $(this);
        var statusCell = $("#status-" + userId);

        // Determinar o novo status com base no texto do botão
        var currentStatus = button.text() === "Liberar" ? 1 : 2;

        $.post("/muda", { id: userId, status_pagamento_id: currentStatus }, function(response){
            console.log("Resposta do servidor:", response); // Log para depuração
            var updatedStatus = response.status_pagamento_id;

            // Atualizar o texto do botão e o status na tabela
            statusCell.text(updatedStatus == 1 ? "Não Pago" : "Pago");
            button.text(updatedStatus == 1 ? "Liberar" : "Bloquear");
        }).fail(function(xhr, status, error) {
            console.error("Erro na requisição:", error); // Log de erro
        });
    });
});
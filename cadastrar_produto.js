const containerImagens = document.getElementById("containerImagens");

function adicionarImagem() {
  const novoDiv = document.createElement("div");
  novoDiv.className = "imagem-input";

  const novoInputURL = document.createElement("input");
  novoInputURL.type = "text";
  novoInputURL.name = "imagem_url[]";
  novoInputURL.placeholder = "URL da imagem";
  novoInputURL.required = true;

  const novoOrdem = document.createElement("input");
  novoOrdem.type = "text";
  novoOrdem.name = "imagem_ordem[]";
  novoOrdem.placeholder = "Ordem";
  novoOrdem.min = 1;
  novoOrdem.required = true;

  novoDiv.appendChild(novoInputURL);
  novoDiv.appendChild(novoOrdem);

  containerImagens.appendChild(novoDiv);
}

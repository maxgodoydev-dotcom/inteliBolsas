<?php
// ============================
// Página de Cursos - InteliBolsas
// Acessível apenas para alunos logados
// ============================

// Inicia sessão
session_start();

// ============================
// VERIFICA SE O ALUNO ESTÁ LOGADO
// ============================
if (!isset($_SESSION['id_aluno'])) {
    header("Location: login.php");
    exit;
}

// Importa conexão com o banco
require '../publico/conexao.php';

$aluno_id = $_SESSION['id_aluno'];

// ============================
// CAPTURA TERMO DE BUSCA OPCIONAL
// ============================
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';

// ============================
// CONSULTA CURSOS + INSTITUIÇÃO
// ============================
$sql = "SELECT c.id, c.titulo AS curso_nome, c.imagem, c.descricao, c.bolsa AS curso_bolsa, c.link_externo, c.vagas, c.data_criacao, c.acessos, i.nome AS instituicao_nome
        FROM cursos c
        INNER JOIN instituicoes i ON c.id_instituicao = i.id
        WHERE c.titulo LIKE ? OR i.nome LIKE ?
        ORDER BY c.data_criacao DESC";

$stmt = $conn->prepare($sql);
$busca_like = "%$busca%";
$stmt->bind_param("ss", $busca_like, $busca_like);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cursos - InteliBolsas</title>

<!-- CSS Global -->
<link rel="stylesheet" href="../publico/css/css_global.css">

<!-- Favicon -->
<link rel="icon" type="image/jpg" href="../publico/imagens/logos/inteliBolsas4.jpg">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ============================ -->
<!-- NAVBAR -->
<!-- ============================ -->
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="../publico/home.php#sobre">
      <img src="../publico/imagens/logos/InteliBolsas1.jpg" class="logo-navbar" alt="Logo InteliBolsas">
    </a>

    <!-- Botão mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
      data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" 
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
         <a class="nav-link NavTexto" href="../publico/home.php">Home</a>
        <!--Verifica se há um sessão de tipo, e se a sessão é do tipo aluno, admin ou instituição -->
        <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'aluno'): ?>
          <a class="nav-link NavTexto" href="../aluno/area_aluno.php">Área Aluno</a>
          <a href="../publico/logout.php" class="btn btn-danger">Sair</a>  
        <?php elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin'): ?>
          <a class="nav-link NavTexto" href="/area_admin.php">Área Admin</a>
          <a href="../publico/logout.php" class="btn btn-danger">Sair</a>  
        <?php elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'instituicao'): ?>
          <a class="nav-link NavTexto" href="area_instituicao.php">Área Inst.</a>
          <a href="../publico/logout.php" class="btn btn-danger">Sair</a>  
        <?php else: ?>
          <a href="../publico/login.php" class="btn btn-success" id="btnLogin">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
 

<!-- ============================ -->
<!-- HEADER -->
<!-- ============================ -->
<header class="fundo d-flex align-items-center justify-content-center" style="height: 40vh;">
  <div class="container text-center text-white">
    <h1 class="TextoPrincipal">Cursos Disponíveis</h1>
    <p class="SubTexto">Escolha, favorite e acesse os cursos que deseja!</p>
  </div>
</header>

<!-- ============================ -->
<!-- CONTEÚDO PRINCIPAL -->
<!-- ============================ -->
<div class="container my-5">
  <div class="row">


  <!-- ============================ -->
<!-- BUSCA -->
<!-- ============================ -->
  <section class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <form class="d-flex shadow-sm" id="formBusca" method="get">
        <input class="form-control me-2" type="search" placeholder="Digite o curso ou bolsa dos seus sonhos..." aria-label="Search" name="busca" value="<?php echo htmlspecialchars($busca); ?>">
        <button class="btn btn-primary" type="submit">Buscar</button>
        <a class="btn" href="cursos.php">Limpar</a> 
      </form>
    </div>
  </div>
</section>

    <!-- FILTROS -->
    <div class="filtro-btns d-flex flex-wrap gap-2 mb-4">
    <button class="btn btn-outline-primary btn-sm" onclick="filtrar('recentes')">Recentes</button>
    <button class="btn btn-outline-primary btn-sm" onclick="filtrar('favoritos')">Favoritos</button>
    <button class="btn btn-outline-primary btn-sm" onclick="filtrar('acessados')">Mais acessados</button>
    <button class="btn btn-outline-primary btn-sm" onclick="filtrar('antigos')">Mais antigos</button>
    <button class="btn btn-secondary btn-sm" onclick="limparFiltros()">Limpar</button>
  </div>

    <!-- LISTAGEM DE CURSOS -->
<div class="row g-4" id="lista">
  <?php while($curso = $result->fetch_assoc()): ?>
    <div class="col-md-4 col-sm-6 curso-item"
         data-id="<?= $curso['id'] ?>"
         data-data="<?= $curso['data_criacao'] ?>"
         data-acessos="<?= $curso['acessos'] ?>">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($curso['curso_nome']) ?></h5>
          <p class="text-muted small mb-2"><?= htmlspecialchars($curso['instituicao_nome']) ?></p>
          <p class="card-text"><?= htmlspecialchars($curso['descricao']) ?></p>
          <p><strong>Vagas:</strong> <?= htmlspecialchars($curso['vagas']) ?></p>
          <p><strong>Bolsa:</strong> <?= htmlspecialchars($curso['curso_bolsa']) ?>%</p>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
          <!-- 🔽 FORM QUE ENVIA VIA POST -->
          <form method="POST" action="../aluno/inscricao.php" class="m-0">
            <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
            <input type="hidden" name="curso_nome" value="<?= htmlspecialchars($curso['curso_nome']) ?>">
            <input type="hidden" name="instituicao_nome" value="<?= htmlspecialchars($curso['instituicao_nome']) ?>">
            <input type="hidden" name="descricao" value="<?= htmlspecialchars($curso['descricao']) ?>">
            <input type="hidden" name="vagas" value="<?= htmlspecialchars($curso['vagas']) ?>">
            <input type="hidden" name="bolsa" value="<?= htmlspecialchars($curso['curso_bolsa']) ?>">
            
            <button type="submit" class="btn btn-outline-primary btn-sm">
              Quero Saber Mais
            </button>
          </form>

          <!-- Estrela de favorito -->
          <span class="star">&#9734;</span>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

  </div>
</div>

<!-- ============================ -->
<!-- FOOTER -->
<!-- ============================ -->
<footer id="contato" class="Contatos text-white py-3">
  <div class="container">
    <div class="row text-center">
      <div class="col-md-4">
        <span>📞 Entre em Contato</span>
      </div>
      <div class="col-md-4">
        <span>© 2025 InteliBolsas | AGJLM Corporation</span>
      </div>
      <div class="col-md-4">
        <span>📍 Nosso Endereço</span>
      </div>
    </div>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS Global -->
<script src="js/global.js"></script>

<!-- JS de Favoritos e Filtros -->
<script>
const lista = document.getElementById("lista");
let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
const itensOriginais = Array.from(lista.querySelectorAll(".curso-item"));

// Inicializa favoritos
itensOriginais.forEach(item => {
  const id = item.dataset.id;
  const star = item.querySelector(".star");
  if (favoritos.includes(id)) {
    star.classList.add("favorito");
    star.innerHTML = "&#9733;";
  }
  star.addEventListener("click", () => {
    if (favoritos.includes(id)) {
      favoritos = favoritos.filter(f => f !== id);
      star.classList.remove("favorito");
      star.innerHTML = "&#9734;";
    } else {
      favoritos.push(id);
      star.classList.add("favorito");
      star.innerHTML = "&#9733;";
    }
    localStorage.setItem("favoritos", JSON.stringify(favoritos));
  });
});

// Funções de filtro
function filtrar(tipo) {
  let itens = Array.from(lista.querySelectorAll(".curso-item"));
  if (tipo === "recentes") {
    itens.sort((a, b) => new Date(b.dataset.data) - new Date(a.dataset.data));
  } else if (tipo === "antigos") {
    itens.sort((a, b) => new Date(a.dataset.data) - new Date(b.dataset.data));
  } else if (tipo === "acessados") {
    itens.sort((a, b) => b.dataset.acessos - a.dataset.acessos);
  } else if (tipo === "favoritos") {
    itens = itens.filter(item => favoritos.includes(item.dataset.id));
  }
  lista.innerHTML = "";
  itens.forEach(item => lista.appendChild(item));
}

function limparFiltros() {
  lista.innerHTML = "";
  itensOriginais.forEach(item => lista.appendChild(item));
}
</script>


</body>
</html>

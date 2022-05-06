<main class="col-9 ms-auto col-lg-10 px-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Productos</h1>
    </div>


    <div class="row my-3">
        <div class="text-right col-9 px-0">
            <h3>Total: $<span id="total">0</span></h3>
        </div>

    </div>

    <h2 class="mb-3">Filtro</h2>

    <div class="filter-container mb-1">

        <div class="row">
            <div class="col-3 mb-3">
                <input type="text" class="form-control" name="name" placeholder="Nombre del producto">
            </div>

            <div class="col-3 mb-3">
                <input type="number" class="form-control" name="price" placeholder="Precio del producto">
            </div>

            <div class="col-3 mb-3">
                <input type="number" class="form-control" name="code" placeholder="Código del producto">
            </div>

        </div>
    </div>
    <nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow mb-2">

        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 navbar-brand-quote" href="#">Productos</a>
    </nav>
    <div class="scroll">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th scope="col">id</th>
                    <th scope="col">Nombre del producto</th>
                    <th scope="col">Precio del producto</th>
                    <th scope="col">Código</th>

                    <th scope="col">Cantidad</th>
                    <th scope="col">Agregado</th>
                </thead>
                <tbody>
                    <?php 
                    $id = 1;
                    foreach ($fpeProducts as $product): ?>
                    <tr>
                        <td><?=$id?></td>
                        <td><?=$product['title']?></td>
                        <td><?=$product['price']?></td>
                        <td><?=$product['code']?></td>
                        <td>
                            <input type="number" name="" id="">
                        </td>
                        <td>
                            <input type="checkbox" name="" id="">
                        </td>
                    </tr>
                    <?php 
                        $id++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>


    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link text-dark" id="previous" href="#">Anterior</a></li>
            <li class="page-item"><a class="page-link text-dark" id="next" href="#">Siguiente</a></li>
        </ul>
    </nav>
</main>
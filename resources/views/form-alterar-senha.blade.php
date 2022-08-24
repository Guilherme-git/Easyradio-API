<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Easy Rádio - Alterar senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body style="width: 100%; height: 100%; background-color: #EAEAEA">

<h1 class="display-6" style="text-align: center; margin-top: 10px">Informe sua nova senha</h1>
<div style="flex: 1; ">
    <div class="container" style="border-color: #666; border-width: 0px; border-style: inset; border-radius: 8px; margin-top: 50px;
    padding: 15px;
    background: rgb(203,231,184);
    background: linear-gradient(90deg, rgba(203,231,184,1) 5%, rgba(144,207,100,1) 34%, rgba(224,206,233,1) 58%, rgba(200,159,219,1) 90%);">
        <div class="container-fluid">
            <form action="salvar-senha" method="post">
                @csrf
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Meu Email</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" value="<?= session()->get('email')  ?>" disabled required>
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Nova senha</label>
                    <input type="password" class="form-control" name="nova_senha" placeholder="Digite sua nova senha" required>
                </div>

                <button type="submit" class="btn" style="background-color: #c89fdb; border-color: #c89fdb; color: #fff">Alterar senha</button>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>

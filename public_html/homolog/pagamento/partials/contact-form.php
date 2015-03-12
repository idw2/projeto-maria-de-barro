<section class="pag-section section-pattern section-form-contact">
    <div  id="form-contact" class='container'>
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-centered" style="margin: 40px auto;">
                    <h2>Peça já sua cotação!</h2>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-6 col-sm-offset-3'>
                <form action="<?php echo SITE . '/form/send-contact.php'; ?>" class="ajax-form" method="post" novalidate="novalidate">
                    <div class="form-group">
                        <label for="name" class="input-required">Seu nome</label>
                        <input type="text" name="name" class="form-control" placeholder="Nome" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="input-required">Seu email</label>
                        <input type="email" name="email" class="form-control" placeholder="email@servidor.com.br" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="tel" name="phone" class="form-control mask_phone" placeholder="(00) 0000-0000">
                    </div>
                    <div class="form-group">
                        <label for="message" class="input-required">Mensagem</label>
                        <textarea name="message" class="form-control" placeholder="Em que podemos ajudar?" required></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-rounded">Enviar cotação</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

<script id="tpt-form-response" type="text/template">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="painel">
                <h2 class='painel-title'>Mensagem enviada com sucesso!</h2>
                <p class="text-lg">Em breve entraremos em contato.</p>
            </div>
        </div>
    </div>
</script>
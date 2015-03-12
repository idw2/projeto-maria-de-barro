<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">

        <li {if $page eq "index"} class="active" {else} class="" {/if}><a href="/{$language}/">Home</a></li>
        <li {if $page eq "aneis"} class="active" {else} class="" {/if}><a href="/{$language}/aneis/">Anéis</a></li>            
        <li {if $page eq "brincos"} class="active" {else} class="" {/if}><a href="/{$language}/brincos/">Brincos</a></li>           
        <li {if $page eq "colares"} class="active" {else} class="" {/if}><a href="/{$language}/colares/">Colares</a></li>           
        <li {if $page eq "pulseiras"} class="active" {else} class="" {/if}><a href="/{$language}/pulseiras/">Pulseiras</a></li>                       
        <li {if $page eq "conjuntos"} class="active" {else} class="" {/if}><a href="/{$language}/conjuntos/">Conjuntos</a></li>                       
        <li {if $page eq "promocoes"} class="active" {else} class="" {/if}><a href="/{$language}/promocoes/">Promoções</a></li>                       
        <li><a target="_blank" href="http://blog.mariadebarro.com.br">Blog</a></li>                       

    </ul>
    <div style="position: relative">
        <form class="navbar-form pull-right search-wrap" role="search" action="/{$language}/novos-produtos" method="post">
            <input type="search" name="search" id="search" class="form-control" placeholder="BUSCAR" autocomplete="off"/>
            <button type="submit" class="btn eu-quero"><span class="fa fa-search"></span></button>
        </form>  
        <div class="sugestao"> </div>
    </div>
            <a href="admin/navbar.tpl"></a>
    <style>
        .sugestao{
            position: absolute;
            background: #fff;
            height: auto;
            right: 0;
            top: 40px;
            width: auto;
            min-width: 250px;
            /*padding: 0.5%;*/
            text-align: left;
            z-index: 500;
            /*max-height: 200px;
            overflow-x: auto;*/
            box-shadow: 0 1px 2px rgba(0,0,0,.2);
        }
    </style>
</div>
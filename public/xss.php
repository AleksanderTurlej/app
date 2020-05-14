<div>
    <form method="GET">

        <input type="text" name="username">
        <button>
            {{ 'search' | trans }}
        </button>
    </form>

    <?php
    echo $_GET['username'];
    ?>
</div>
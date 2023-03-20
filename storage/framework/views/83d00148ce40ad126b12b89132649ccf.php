

<?php $__env->startSection('layout'); ?>

    <body class="d-flex text-center text-white bg-dark">
        <div class="cover-container d-flex w-100 mx-auto flex-column">
            <main class="h-100">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </body>

    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\el_ma\OneDrive\Escritorio\tarea_solutoria\resources\views/layout.blade.php ENDPATH**/ ?>
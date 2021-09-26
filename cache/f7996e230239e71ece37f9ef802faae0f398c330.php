<?php $__currentLoopData = $commits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
### <?php echo e($group); ?>


<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
- <?php echo e($item['message']); ?> (<?php echo e(substr($item['sha'], 0, 8)); ?>, <?php echo e('@'.$item['author']); ?>)
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if($repo === 'desktop-wallet'): ?>
### Hashes

| File | SHA256 |
| --- | --- |
| linux-amd64.deb | - |
| linux-x64.tar.gz | - |
| linux-x86_64.AppImage | - |
| mac.dmg | - |
| mac.zip | - |
| win.exe | - |

<?php endif; ?>
Thanks to <?php $__currentLoopData = $contributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e('@'.$contributor); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__currentLoopData = $commits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($item['number']): ?>
[#<?php echo e($item['number']); ?>]: https://github.com/<?php echo e($user); ?>/<?php echo e($repo); ?>/pull/<?php echo e($item['number']); ?>

<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/brianfaust/PayvoHQ/ghlogs/views/changelog.blade.php ENDPATH**/ ?>
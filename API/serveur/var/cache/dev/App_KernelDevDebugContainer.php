<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container3diy6gW\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container3diy6gW/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container3diy6gW.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container3diy6gW\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \Container3diy6gW\App_KernelDevDebugContainer([
    'container.build_hash' => '3diy6gW',
    'container.build_id' => 'e056aa88',
    'container.build_time' => 1613686181,
], __DIR__.\DIRECTORY_SEPARATOR.'Container3diy6gW');

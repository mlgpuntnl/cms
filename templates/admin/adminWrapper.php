<?php $this->layout('admin/wrapper', ['title' => 'Login']) ?>

<?php $this->start('main-content'); ?>

    <?php if ($this->section('sidebar')) : ?>
        <?= $this->section('sidebar') ?>
    <?php else : ?>
        <?= $this->fetch('admin/partials/default-sidebar', compact('currentPage')) ?>
    <?php endif; ?>
    <main class="page-content">
        <?= $this->section('main-content') ?>
    </main>

<?php $this->end();

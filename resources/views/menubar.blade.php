<?php
// This View triggers the MenubarComposer when it is invoked.
// The MenubarComposer determines which menubar template to
// display and returns $menubar_type
//
// Invokes 'app/Http/ViewComposers/MenubarComposer.php'
// This binding is registered in 'app/Providers/ComposerServiceProvider.php'
?>
@include('menubar.'.$menubar_type)

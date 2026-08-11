<div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-X+XdYacHJL7rOTpD/xB8M+8gtnltVGnnG/4Z/bx4PPFCFgCeaPdjXPMp0z3CAmzE" crossorigin="anonymous">

    <?php if($operativo->estado == 'Pendiente'): ?>
        <?php if($operativo->cantidadtotal == 0): ?>
            <div class="container d-flex">
                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-success d-flex align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="CONFIRMAR TRATAMIENTO"
                    data-original-title="Edit"wire:click="$set('editar',true)">
                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4"
                            d="M16.3405 1.99976H7.67049C4.28049 1.99976 2.00049 4.37976 2.00049 7.91976V16.0898C2.00049 19.6198 4.28049 21.9998 7.67049 21.9998H16.3405C19.7305 21.9998 22.0005 19.6198 22.0005 16.0898V7.91976C22.0005 4.37976 19.7305 1.99976 16.3405 1.99976Z"
                            fill="currentColor"></path>
                        <path
                            d="M10.8134 15.248C10.5894 15.248 10.3654 15.163 10.1944 14.992L7.82144 12.619C7.47944 12.277 7.47944 11.723 7.82144 11.382C8.16344 11.04 8.71644 11.039 9.05844 11.381L10.8134 13.136L14.9414 9.00796C15.2834 8.66596 15.8364 8.66596 16.1784 9.00796C16.5204 9.34996 16.5204 9.90396 16.1784 10.246L11.4324 14.992C11.2614 15.163 11.0374 15.248 10.8134 15.248Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>

                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-warning d-flex align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="REAGENDAR"
                    data-original-title="Editar"wire:click="$set('openArea',true)">
                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4"
                            d="M19.9927 18.9534H14.2984C13.7429 18.9534 13.291 19.4124 13.291 19.9767C13.291 20.5422 13.7429 21.0001 14.2984 21.0001H19.9927C20.5483 21.0001 21.0001 20.5422 21.0001 19.9767C21.0001 19.4124 20.5483 18.9534 19.9927 18.9534Z"
                            fill="currentColor"></path>
                        <path
                            d="M10.309 6.90385L15.7049 11.2639C15.835 11.3682 15.8573 11.5596 15.7557 11.6929L9.35874 20.0282C8.95662 20.5431 8.36402 20.8344 7.72908 20.8452L4.23696 20.8882C4.05071 20.8903 3.88775 20.7613 3.84542 20.5764L3.05175 17.1258C2.91419 16.4915 3.05175 15.8358 3.45388 15.3306L9.88256 6.95545C9.98627 6.82108 10.1778 6.79743 10.309 6.90385Z"
                            fill="currentColor"></path>
                        <path opacity="0.4"
                            d="M18.1208 8.66544L17.0806 9.96401C16.9758 10.0962 16.7874 10.1177 16.6573 10.0124C15.3927 8.98901 12.1545 6.36285 11.2561 5.63509C11.1249 5.52759 11.1069 5.33625 11.2127 5.20295L12.2159 3.95706C13.126 2.78534 14.7133 2.67784 15.9938 3.69906L17.4647 4.87078C18.0679 5.34377 18.47 5.96726 18.6076 6.62299C18.7663 7.3443 18.597 8.0527 18.1208 8.66544Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>

                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-danger d-flex align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="ELIMINAR" data-original-title="Edit"
                    wire:click="$emit('inactivarOperativo',<?php echo e($operativo->id); ?>)">
                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4"
                            d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                            fill="currentColor"></path>
                        <path
                            d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>



                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-primary d-flex align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="INFORMACIÓN DE CITA" data-original-title="Ver cliente"
                    wire:click="$set('openArea5',true)">

                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                            d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z"
                            fill="currentColor"></path>
                        <path
                            d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>

                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-info d-flex align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="AGREGAR TRATAMIENTO" data-original-title="Edit"
                    wire:click="$set('agreagar',true)">
                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2 16.08V7.91C2 4.38 4.271 2 7.66 2H16.33C19.72 2 22 4.38 22 7.91V16.08C22 19.62 19.72 22 16.33 22H7.66C4.271 22 2 19.62 2 16.08ZM12.75 14.27V7.92C12.75 7.5 12.41 7.17 12 7.17C11.58 7.17 11.25 7.5 11.25 7.92V14.27L8.78 11.79C8.64 11.65 8.44 11.57 8.25 11.57C8.061 11.57 7.87 11.65 7.72 11.79C7.43 12.08 7.43 12.56 7.72 12.85L11.47 16.62C11.75 16.9 12.25 16.9 12.53 16.62L16.28 12.85C16.57 12.56 16.57 12.08 16.28 11.79C15.98 11.5 15.51 11.5 15.21 11.79L12.75 14.27Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>

                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-success d-flex align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="ENVIAR MENSAJE" data-original-title="Edit" wire:click="enviarcompra">

                    <span class="ms-1" style="font-size: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path
                                d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                        </svg></span>

                </a>
                <a class="mt-1 mr-2 btn btn-sm btn-icon btn-warning d-flex align-items-center"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="REMARKETING" data-original-title="Edit"
                    wire:click="$emit('rellamarOperativo',<?php echo e($operativo->id); ?>)">
                    <svg class="icon-15" width="15" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.5317 12.4724C15.5208 16.4604 16.4258 11.8467 18.9656 14.3848C21.4143 16.8328 22.8216 17.3232 19.7192 20.4247C19.3306 20.737 16.8616 24.4943 8.1846 15.8197C-0.493478 7.144 3.26158 4.67244 3.57397 4.28395C6.68387 1.17385 7.16586 2.58938 9.61449 5.03733C12.1544 7.5765 7.54266 8.48441 11.5317 12.4724Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>
            </div>
        <?php else: ?>
            <div class="container d-flex">
                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-primary d-flex align-items-center"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Ver cliente"
                    data-original-title="INFORMACIÓN DE CITA" wire:click="$set('openArea5',true)">

                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                            d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z"
                            fill="currentColor"></path>
                        <path
                            d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>
                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-info d-flex align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="AGREGAR TRATAMIENTO" data-original-title="Edit"
                    wire:click="$set('agreagar',true)">
                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2 16.08V7.91C2 4.38 4.271 2 7.66 2H16.33C19.72 2 22 4.38 22 7.91V16.08C22 19.62 19.72 22 16.33 22H7.66C4.271 22 2 19.62 2 16.08ZM12.75 14.27V7.92C12.75 7.5 12.41 7.17 12 7.17C11.58 7.17 11.25 7.5 11.25 7.92V14.27L8.78 11.79C8.64 11.65 8.44 11.57 8.25 11.57C8.061 11.57 7.87 11.65 7.72 11.79C7.43 12.08 7.43 12.56 7.72 12.85L11.47 16.62C11.75 16.9 12.25 16.9 12.53 16.62L16.28 12.85C16.57 12.56 16.57 12.08 16.28 11.79C15.98 11.5 15.51 11.5 15.21 11.79L12.75 14.27Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>
                <a class="mt-1 mr-1 btn btn-sm btn-icon btn-danger d-flex align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="ELIMINAR" data-original-title="Edit"
                    wire:click="$emit('inactivarOperativo',<?php echo e($operativo->id); ?>)">
                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4"
                            d="M16.34 1.99976H7.67C4.28 1.99976 2 4.37976 2 7.91976V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.91976C22 4.37976 19.73 1.99976 16.34 1.99976Z"
                            fill="currentColor"></path>
                        <path
                            d="M15.0158 13.7703L13.2368 11.9923L15.0148 10.2143C15.3568 9.87326 15.3568 9.31826 15.0148 8.97726C14.6728 8.63326 14.1198 8.63426 13.7778 8.97626L11.9988 10.7543L10.2198 8.97426C9.87782 8.63226 9.32382 8.63426 8.98182 8.97426C8.64082 9.31626 8.64082 9.87126 8.98182 10.2123L10.7618 11.9923L8.98582 13.7673C8.64382 14.1093 8.64382 14.6643 8.98582 15.0043C9.15682 15.1763 9.37982 15.2613 9.60382 15.2613C9.82882 15.2613 10.0518 15.1763 10.2228 15.0053L11.9988 13.2293L13.7788 15.0083C13.9498 15.1793 14.1728 15.2643 14.3968 15.2643C14.6208 15.2643 14.8448 15.1783 15.0158 15.0083C15.3578 14.6663 15.3578 14.1123 15.0158 13.7703Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>
                <a class="mt-1 mr-2 btn btn-sm btn-icon btn-warning d-flex align-items-center"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="REMARKETING" data-original-title="Edit"
                    wire:click="$emit('rellamarOperativo',<?php echo e($operativo->id); ?>)">
                    <svg class="icon-15" width="15" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.5317 12.4724C15.5208 16.4604 16.4258 11.8467 18.9656 14.3848C21.4143 16.8328 22.8216 17.3232 19.7192 20.4247C19.3306 20.737 16.8616 24.4943 8.1846 15.8197C-0.493478 7.144 3.26158 4.67244 3.57397 4.28395C6.68387 1.17385 7.16586 2.58938 9.61449 5.03733C12.1544 7.5765 7.54266 8.48441 11.5317 12.4724Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="ms-1" style="font-size: 8px;"></span>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>



    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'agreagar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'agreagar']); ?>
        <div class="form-group" style="margin-bottom: 35px;">
            <label class="form-label" for="">Selecciona tratamientos para agregar:</label>
            <div class="">
                <input type="text" class="form-control" id="exampleInputDisabled1"
                    wire:model="busquedatratamiento" placeholder="Buscar tratamiento...">
            </div>
            <?php $__currentLoopData = $mistratamientospara; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tratamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <div>
                        <input type="checkbox"
                            wire:model.defer="tratamientosSeleccionadosnuevos.<?php echo e($tratamiento->id); ?>"
                            value="<?php echo e($tratamiento->id); ?>">
                        <label for=""><?php echo e($tratamiento->nombre); ?>(<?php echo e($tratamiento->costo . 'Bs.'); ?>)</label>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="mt-4 form-group">
                <label class="form-label" for="">Monto para aumentar al pago:</label>
                <input type="number" class="form-control" id="exampleInputDisabled1" wire:model.defer="pagonuevo">
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="agregartratamientos">Confirmar</label>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'openArea']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'openArea']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                REAGENDAR CITA DE: <?php echo e($operativo->empresa); ?>

            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group" style="margin-right: 5%;">
                        <label>Sucursal: </label>
                        <select wire:model="operativo.area">
                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lista->area); ?>"><?php echo e($lista->area); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputdate">Fecha de cita:</label>
                        <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                            wire:model.defer="operativo.fecha">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hora de cita:</label>
                        <div class="d-flex">
                            <select name="type" class="selectpicker form-control" data-style="py-0"
                                wire:model.defer="hora">
                                <option>Seleccionar hora</option>
                                <option>00</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option>23</option>

                            </select>
                            <select name="type" class="selectpicker form-control" data-style="py-0"
                                wire:model.defer="minuto">
                                <option>Seleccionar minuto</option>
                                <option>00</option>
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                                <option>25</option>
                                <option>30</option>
                                <option>35</option>
                                <option>40</option>
                                <option>45</option>
                                <option>50</option>
                                <option>55</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Agrear comentario(opcional):</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="operativo.comentario">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            value="<?php echo e(Auth::user()->name); ?>">
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="guardaroperativogeneral">Guardar</label>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'editar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'editar']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                CONFIRMAR CITA DE: <?php echo e($operativo->empresa); ?>

            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">Agrear comentario (opcional):</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1"
                            wire:model.defer="operativo.comentario">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputDisabled1">Regitrado por:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            value="<?php echo e(Auth::user()->name); ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 35px;">
                        <label class="form-label" for="">Seleccione tratamientos realizados (SOLO SI FUE
                            FINALIZADO):</label>
                        <?php $__currentLoopData = $tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>
                                <div>
                                    <?php if(in_array($lista->idtratamiento, $tratamientosSeleccionados)): ?>
                                        <div style="display: flex;">
                                            <input type="checkbox"
                                                wire:click="toggleTratamiento(<?php echo e($lista->idtratamiento); ?>)" checked
                                                disabled>
                                            <label
                                                for=""><?php echo e($lista->nombretratamiento); ?>(<?php echo e($lista->costo); ?>.Bs)</label>
                                        </div>
                                    <?php else: ?>
                                        <div style="display: flex;">
                                            <input type="checkbox"
                                                wire:click="toggleTratamiento(<?php echo e($lista->idtratamiento); ?>)">
                                            <label
                                                for=""><?php echo e($lista->nombretratamiento); ?>(<?php echo e($lista->costo); ?>.Bs)</label>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="mt-2 form-group">
                        <label class="form-label" for="">Encargado de cita (Cosmetologa):</label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="elegido">
                            <option value="">Seleccionar operario</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php $__errorArgs = ['elegido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick">Encargad@ de cita requerido</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php if(!$haycuota): ?>
                        <div class="mb-2 form-group">
                            <label class="form-label" for="">Cantidad de pagos: </label>
                            <select name="type" class="selectpicker form-control" data-style="py-0"
                                wire:model="pagos">
                                <option value="uno">UN SOLO PAGO</option>
                                <option value="varios">VARIOS PAGOS</option>
                            </select>
                        </div>
                        <?php if($pagos == 'uno'): ?>
                            <div class="form-group">
                                <label class="form-label" for="">PAGO REALIZADO:</label>
                                <input type="number" class="form-control" id="exampleInputDisabled1"
                                    wire:model="pagototal">
                            </div>
                        <?php else: ?>
                            <div class="form-group">
                                <label class="form-label" for="">MONTO DE COBRO TOTAL POR PAQUETE(s):</label>
                                <input type="number" class="form-control" id="exampleInputDisabled1"
                                    wire:model="pagototal">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="">MONTO RECIBIDO INICIAL:</label>
                                <input type="number" class="form-control" id="exampleInputDisabled1"
                                    wire:model="cuota1">
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="mb-2 form-group">
                            <label class="form-label" for="">Deuda pendiente: </label>
                            <input type="number" class="form-control" id="exampleInputDisabled1" wire:model="deuda"
                                disabled>
                        </div>
                        <div class="mb-2 form-group">
                            <label class="form-label" for="">Cantidad a pagar: </label>
                            <input type="number" class="form-control" id="exampleInputDisabled1"
                                wire:model.defer="cantidadpago">
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputdate">Fecha siguiente cita (SOLO SI NO
                            FINALIZO):</label>
                        <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                            wire:model.defer="operativo.fecha">
                    </div>
                    <?php $__errorArgs = ['operativo.fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick">Fecha requerida</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-group">
                        <label class="form-label">Hora siguiente cita (SOLO SI NO FINALIZO):</label>
                        <div class="d-flex">
                            <select name="type" class="selectpicker form-control" data-style="py-0"
                                wire:model.defer="hora">
                                <option>Seleccionar hora</option>
                                <option>00</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option>23</option>
                            </select>
                            <select name="type" class="selectpicker form-control" data-style="py-0"
                                wire:model.defer="minuto">
                                <option>Seleccionar minuto</option>
                                <option>00</option>
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                                <option>25</option>
                                <option>30</option>
                                <option>35</option>
                                <option>40</option>
                                <option>45</option>
                                <option>50</option>
                                <option>55</option>
                            </select>
                        </div>
                    </div>
                    <?php $__errorArgs = ['hora'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick">Hora requerida</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['minuto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label style="color:firebrick">Minuto requerido</label>
                        <br>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="mb-2 form-group">
                        <label class="form-label" for="">Modo de pago: </label>
                        <select name="type" class="selectpicker form-control" data-style="py-0"
                            wire:model.defer="mododepago">
                            <option value="QR">QR</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
            <label type="submit" class="btn btn-success" wire:click="confirmar">Confirmar</label>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model.defer' => 'openArea5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'openArea5']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Información de tratamiendo:
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <form>
                    <div class="form-group">
                        <label class="form-label" for="">Nombre de cliente: </label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            wire:model.defer="operativo.empresa">
                        <label class="form-label" for="">Numero de cliente: </label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            wire:model.defer="operativo.telefono">
                        <label class="form-label" for="">Ultimo comentario: </label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            wire:model.defer="operativo.comentario">

                        <label class="form-label" for="">Pago Total: </label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            wire:model.defer="total">
                        <label class="form-label" for="">Deuda:</label>
                        <input type="text" class="form-control" id="exampleInputDisabled1" disabled=""
                            wire:model.defer="deuda">
                    </div>
                    <div class="form-group">
                        <div class="px-4 card-body">
                            <div class="table-responsive">
                                <table id="user-list-table" class="" role="grid"
                                    data-bs-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th style=" width: 300px;">TRATAMIENTO</th>
                                            <th>FECHA</th>
                                            <th>ESTADO</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                            $mistratamientos = DB::table('historial_clientes')
                                                ->where('idoperativo', $operativo->id)
                                                ->get();
                                        ?>
                                        <?php $__currentLoopData = $mistratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <?php
                                                    $collection = DB::table('tratamientos')
                                                        ->where('id', $item->idtratamiento)
                                                        ->get();
                                                ?>
                                                <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td style=" width: 300px;"><?php echo e($coll->nombre); ?></td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <td><?php echo e($item->fecha); ?></td>
                                                <?php if($item->estado == 'Activo'): ?>
                                                    <td>Realizado</td>
                                                <?php else: ?>
                                                    <td>Pendiente</td>
                                                <?php endif; ?>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <style>
                                    .container-but {
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                    }
                                </style>
                            </div>
                        </div>

                </form>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'rellamarnumero']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'rellamarnumero']); ?>
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                ¿Volvió a llamar: con teléfono: ?
            </div>
        </div>
        <div class="flex flex-row justify-end px-1 py-1 text-right bg-gray-100">
            <label type="submit" class="mr-2 btn btn-light" wire:click="cancelar">Cancelar</label>
            <label type="submit" class="btn btn-success" wire:click="rellamarnum">Si llamé</label>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\miora-project\resources\views/livewire/operativos/editar-operativo.blade.php ENDPATH**/ ?>
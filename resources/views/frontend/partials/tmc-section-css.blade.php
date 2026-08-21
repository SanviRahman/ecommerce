@push('css')
<style>
/* Reusable TMC section: Home + Products page */
.tmc-section .container {
    max-width: 1020px;
}

/* TMC */
.tmc-section {
    min-height: 558px;
    padding-top: 34px;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}

.tmc-rule {
    height: 1px;
    margin: 35px 0 22px;
    background: #d7d7d7;
}

.tmc-row {
    min-height: 340px;
}

.tmc-copy {
    max-width: 465px;
    margin: 0;
    color: #162d47;
    font-size: 13px;
    line-height: 1.9;
}

.tmc-list {
    margin: 20px 0 0;
    padding: 0;
    list-style: none;
}

.tmc-list li {
    position: relative;
    margin-bottom: 12px;
    padding-left: 19px;
    color: #172c45;
    font-size: 13px;
    line-height: 1.9;
}

.tmc-list li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 9px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #e5b251;
}

.tmc-btn {
    margin-top: 17px;
}

.tmc-art {
    min-height: 340px;
    overflow: visible;
}

.tmc-plank-stage {
    position: relative;
    height: 312px;
    transition: transform .75s cubic-bezier(.16, 1, .3, 1);
}

.tmc-plank-stage:hover {
    transform: scale(1.035);
}

#tmcCarousel .carousel-item.active .tmc-plank {
    animation: tmcPlankZoomIn 1.05s cubic-bezier(.16, 1, .3, 1) both;
}

#tmcCarousel .carousel-item.active .plank-2 {
    animation-delay: .08s;
}

#tmcCarousel .carousel-item.active .plank-3 {
    animation-delay: .16s;
}

#tmcCarousel .carousel-item.active .plank-4 {
    animation-delay: .24s;
}

@keyframes tmcPlankZoomIn {
    from {
        opacity: 0;
        transform: scale(.76) translateY(26px);
    }

    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.tmc-plank {
    position: absolute;
    top: 35px;
    width: 205px;
    height: 205px;
    object-fit: contain;
}

.tmc-plank.plank-1 {
    left: 0;
    z-index: 1;
}

.tmc-plank.plank-2 {
    left: 104px;
    z-index: 2;
}

.tmc-plank.plank-3 {
    left: 208px;
    z-index: 3;
}

.tmc-plank.plank-4 {
    left: 312px;
    z-index: 4;
}

.tmc-stage-2 {
    transform: translateX(5px);
}

.tmc-stage-3 {
    transform: translateX(-5px);
}

.tmc-indicators {
    bottom: 4px;
    left: 0;
    right: auto;
    width: 100%;
    margin: 0;
    z-index: 5;
}

.tmc-indicators li {
    width: 21px;
    height: 3px;
    margin: 0 5px;
    border: 0;
    background: #dfd4bf;
    opacity: 1;
}

.tmc-indicators .active {
    background: #c9a967;
}

@media (max-width: 991.98px) {
    .tmc-section .container {
        max-width: 720px;
    }

    .tmc-section {
        min-height: auto;
    }

    .tmc-row {
        min-height: auto;
    }

    .tmc-plank {
        width: 165px;
        height: 165px;
    }

    .tmc-plank.plank-2 {
        left: 82px;
    }

    .tmc-plank.plank-3 {
        left: 164px;
    }

    .tmc-plank.plank-4 {
        left: 246px;
    }
}

@media (max-width: 767.98px) {
    .tmc-section .container {
        max-width: 540px;
    }

    .tmc-art {
        min-height: 285px;
        padding-bottom: 30px;
        overflow: visible;
    }

    .tmc-indicators {
        bottom: 4px;
    }

    .tmc-plank-stage {
        left: 50%;
        width: 517px;
        transform: translateX(-50%) scale(.82);
        transform-origin: center center;
    }

    .tmc-plank-stage:hover {
        transform: translateX(-50%) scale(.82);
    }
}

@media (max-width: 575.98px) {
    .tmc-section .container {
        width: calc(100% - 30px);
        max-width: none;
    }

    .tmc-plank-stage {
        left: 50%;
        width: 517px;
        height: 220px;
        transform: translateX(-50%) scale(.62);
        transform-origin: center center;
    }

    .tmc-plank-stage:hover {
        transform: translateX(-50%) scale(.62);
    }

    .tmc-art {
        min-height: 260px;
        padding-bottom: 30px;
        overflow: visible;
    }

    .tmc-indicators {
        bottom: 2px;
    }
}
</style>
@endpush

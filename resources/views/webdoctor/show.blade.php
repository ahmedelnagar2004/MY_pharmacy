<x-user-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold m-0">
                    <i class="fas fa-user-md me-2"></i>{{ $doctor->name }}
                </h2>
                <p class="text-muted mb-0 mt-1">{{ $doctor->specialty }}</p>
            </div>
            <div>
                <a href="{{ route('webdoctor.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i> العودة للقائمة
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="row">
            <!-- معلومات الطبيب -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <div class="doctor-img-container mb-3">
                            <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->name }}" class="img-fluid rounded-circle" style="width: 180px; height: 180px; object-fit: cover; border: 5px solid rgba(0, 123, 255, 0.1);">
                        </div>
                        <h4 class="mb-1">د. {{ $doctor->name }}</h4>
                        <p class="text-primary mb-3">{{ $doctor->specialty }}</p>
                        
                        <div class="doctor-info mt-4">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="fw-bold">رقم الهاتف:</span>
                                <span>{{ $doctor->number }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="fw-bold">سعر الكشف:</span>
                                <span>{{ $doctor->price }} ج.م</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="fw-bold">تاريخ الانضمام:</span>
                                <span>{{ $doctor->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>
                        
                        <div class="doctor-actions mt-4">
                            <a href="{{ route('appointments.create', $doctor->id) }}" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-calendar-check me-1"></i> حجز موعد
                            </a>
                            <a href="tel:{{ $doctor->number }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-phone me-1"></i> اتصال
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- المزيد من المعلومات والصور -->
            <div class="col-lg-8">
                <!-- الصور الإضافية -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">صور إضافية</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php
                                $hasAdditionalImages = false;
                            @endphp
                            
                            @for ($i = 1; $i <= 5; $i++)
                                @if(isset($doctor->{"image-$i"}))
                                    @php
                                        $hasAdditionalImages = true;
                                    @endphp
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ asset('storage/' . $doctor->{"image-$i"}) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $doctor->{"image-$i"}) }}" class="img-fluid rounded" alt="صورة إضافية {{ $i }}">
                                        </a>
                                    </div>
                                @endif
                            @endfor
                            
                            @if(!$hasAdditionalImages)
                                <div class="col-12 text-center py-4">
                                    <i class="fas fa-images fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">لا توجد صور إضافية</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- مواعيد الطبيب -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">مواعيد الطبيب</h5>
                        <span class="badge bg-success">متاح</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 text-center">
                            <div class="col-md-3">
                                <div class="p-3 border rounded mb-2">
                                    <h6 class="mb-1">السبت</h6>
                                    <p class="mb-0 small">10:00 ص - 2:00 م</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded mb-2">
                                    <h6 class="mb-1">الأحد</h6>
                                    <p class="mb-0 small">10:00 ص - 2:00 م</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded mb-2">
                                    <h6 class="mb-1">الاثنين</h6>
                                    <p class="mb-0 small">10:00 ص - 2:00 م</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded mb-2">
                                    <h6 class="mb-1">الثلاثاء</h6>
                                    <p class="mb-0 small">10:00 ص - 2:00 م</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded mb-2">
                                    <h6 class="mb-1">الأربعاء</h6>
                                    <p class="mb-0 small">10:00 ص - 2:00 م</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded mb-2">
                                    <h6 class="mb-1">الخميس</h6>
                                    <p class="mb-0 small">1:00 م - 5:00 م</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded mb-2 bg-light">
                                    <h6 class="mb-1 text-muted">الجمعة</h6>
                                    <p class="mb-0 small text-danger">مغلق</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- آراء المرضى -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">آراء المرضى</h5>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ms-1 text-dark">(4.5)</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="review-item pb-3 mb-3 border-bottom">
                            <div class="d-flex">
                                <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="صورة المريض">
                                <div>
                                    <h6 class="mb-1">محمد أحمد</h6>
                                    <div class="text-warning small">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p class="text-muted small">منذ أسبوع</p>
                                </div>
                            </div>
                            <p class="mt-2">دكتور ممتاز ومتعاون جداً. شرح جميع التفاصيل بوضوح وكان الكشف دقيق.</p>
                        </div>
                        <div class="review-item">
                            <div class="d-flex">
                                <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="صورة المريض">
                                <div>
                                    <h6 class="mb-1">سمر محمود</h6>
                                    <div class="text-warning small">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <p class="text-muted small">منذ أسبوعين</p>
                                </div>
                            </div>
                            <p class="mt-2">كشف دقيق وشرح واضح للحالة. سعر الكشف مناسب مقارنة بالخدمة الممتازة.</p>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-comment-medical me-1"></i> إضافة تقييم
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout> 
<x-user-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold m-0">
                    <i class="fas fa-user-md me-2"></i>قائمة الأطباء
                </h2>
                <p class="text-muted mb-0 mt-1">استعرض قائمة الأطباء المتاحين في نظامنا</p>
            </div>
        </div>
    </x-slot>

    <div class="container py-4">
        <!-- تصفية وبحث -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" placeholder="ابحث عن طبيب...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>كل التخصصات</option>
                            <option value="عظام">عظام</option>
                            <option value="جلدية">جلدية</option>
                            <option value="باطنة">باطنة</option>
                            <option value="أطفال">أطفال</option>
                            <option value="نساء وتوليد">نساء وتوليد</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @if(count($doctors) > 0)
            <div class="row g-4">
                @foreach($doctors as $doctor)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm doctor-card">
                            <div class="position-relative">
                                <img src="{{ asset('storage/'.$doctor->image) }}" class="card-img-top" alt="{{ $doctor->name }}" style="height: 200px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-primary">{{ $doctor->specialty }}</span>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <div class="doctor-image mt-n5 mb-3">
                                    <img src="{{ asset('storage/'.$doctor->image) }}" class="rounded-circle border-4 border-white shadow" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $doctor->name }}">
                                </div>
                                <h4 class="card-title">د. {{ $doctor->name }}</h4>
                                <p class="card-text text-primary mb-2">{{ $doctor->specialty }}</p>
                                
                                <div class="d-flex justify-content-center text-warning mb-3">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1 text-dark">(4.5)</span>
                                </div>
                                
                                <div class="doctor-info mb-3">
                                    <div class="d-flex justify-content-between small py-1 border-bottom">
                                        <span class="text-muted">سعر الكشف:</span>
                                        <span class="fw-bold">{{ $doctor->price }} ج.م</span>
                                    </div>
                                    <div class="d-flex justify-content-between small py-1">
                                        <span class="text-muted">رقم الهاتف:</span>
                                        <span class="fw-bold">{{ $doctor->number }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0 pt-0">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('webdoctor.show', $doctor->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> عرض التفاصيل
                                    </a>
                                    <a href="#" class="btn btn-sm btn-primary book-appointment-btn" data-doctor-id="{{ $doctor->id }}" data-doctor-name="د. {{ $doctor->name }}">
                                        <i class="fas fa-calendar-plus me-1"></i> حجز موعد
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- ترقيم الصفحات -->
            <div class="d-flex justify-content-center mt-5">
                {{ $doctors->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <img src="{{ asset('images/no-doctors.svg') }}" alt="لا يوجد أطباء" style="max-width: 200px; opacity: 0.7">
                <h4 class="mt-3">لا يوجد أطباء حالياً</h4>
                <p class="text-muted">سيتم إضافة أطباء قريباً، تابعنا!</p>
            </div>
        @endif
    </div>

    <style>
        .doctor-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .doctor-card:hover {
            transform: translateY(-10px);
        }
        
        .doctor-image img {
            transition: all 0.3s ease;
            z-index: 10;
            position: relative;
        }
        
        .doctor-card:hover .doctor-image img {
            transform: scale(1.1);
        }
        
        .pagination {
            --bs-pagination-active-bg: var(--main-color);
            --bs-pagination-active-border-color: var(--main-color);
        }
    </style>
</x-user-layout>

<x-admin-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold m-0">
                    <i class="fas fa-pills me-2"></i>تعديل بيانات الدواء
                </h2>
                <p class="text-muted mb-0 mt-1">تعديل بيانات الدواء: {{ $medicien->name }}</p>
            </div>
            <div>
                <a href="{{ route('medicien.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i> العودة للقائمة
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('medicien.update', $medicien->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">اسم الدواء <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $medicien->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="propose" class="form-label">الغرض من الدواء <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('propose') is-invalid @enderror" id="propose" name="propose" rows="3" required>{{ old('propose', $medicien->propose) }}</textarea>
                                        @error('propose')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="price" class="form-label">سعر الدواء <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $medicien->price) }}" required>
                                            <span class="input-group-text">ج.م</span>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">صورة الدواء</label>
                                        <div class="image-preview text-center mb-2">
                                            <img id="preview-image" src="{{ asset('storage/' . $medicien->image) }}" alt="{{ $medicien->name }}" class="img-fluid rounded" style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">اترك هذا الحقل فارغاً إذا كنت لا ترغب في تغيير الصورة</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end pt-3 border-top">
                                <a href="{{ route('medicien.index') }}" class="btn btn-light me-2">إلغاء</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Script -->
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('preview-image').src = event.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</x-admin-layout> 
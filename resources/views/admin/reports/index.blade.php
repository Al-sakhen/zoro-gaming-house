@extends('admin.layout.app')

@section('breadcrumb')
    @include('admin.layout.partials.page-header', [
        'title' => 'Reports & Analytics',
        'links' => [
            [
                'name' => 'Dashboard',
                'url' => route('dashboard'),
            ],
        ],
    ])
@endsection

@push('styles')
    <style>
        /* Reports Page Styling */
        .reports-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
        }

        .reports-container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('/gaming-bg.svg');
            background-size: 100px 100px;
            background-repeat: repeat;
            opacity: 0.1;
            pointer-events: none;
            z-index: 0;
        }

        .container-fluid {
            position: relative;
            z-index: 1;
        }

        /* Glass Effect Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .glass-card-white {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* Stat Cards */
        .stat-card-report {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card-report:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .stat-icon-report {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        /* Progress Bars */
        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.3);
        }

        .progress-custom .progress-bar {
            border-radius: 10px;
        }

        /* Buttons */
        .btn-glass {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .btn-glass:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
            color: white;
        }

        /* Form Controls */
        .form-control-glass {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .form-control-glass::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control-glass:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideInUp 0.6s ease-out;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <livewire:reports />
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            console.log('Reports page loaded with analytics');

            // Add smooth scrolling to report sections
            document.querySelectorAll('.slide-in').forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
@endpush

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Blog Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            background-color: #0f172a;
            background: radial-gradient(circle at top left, #1e293b, #0f172a),
                        radial-gradient(circle at bottom right, #312e81, #0f172a);
            background-blend-mode: screen;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-field {
            background: rgba(30, 41, 59, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: #818cf8;
            background: rgba(30, 41, 59, 0.6);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #818cf8 0%, #a855f7 100%);
            box-shadow: 0 8px 20px rgba(129, 140, 248, 0.2);
        }

        .btn-gradient:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); }
        .alert-danger { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }

        .logo-box {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #818cf8, #a855f7);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 16px rgba(129, 140, 248, 0.2);
        }

        .password-toggle {
            cursor: pointer;
            transition: transform 0.1s;
        }
        .password-toggle:active { transform: scale(0.9); }
    </style>
</head>
<body>
    <div class="w-full max-w-[440px] p-6">
        <div class="glass-card rounded-[2.5rem] p-10 relative overflow-hidden text-white">
            
            <!-- Logo Icon -->
            <div class="logo-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" />
                    <path d="M2 17L12 22L22 17" />
                    <path d="M2 12L12 17L22 12" />
                </svg>
            </div>

            <h1 class="text-3xl font-bold mb-2">Create Account</h1>
            <p class="text-slate-400 mb-8 text-sm">Join the Blog Platform today</p>

            <!-- PHP Alerts -->
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    <span><?php echo $this->session->flashdata('success'); ?></span>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span><?php echo $this->session->flashdata('error'); ?></span>
                </div>
            <?php endif; ?>

            <?php if(validation_errors()): ?>
                <div class="alert alert-danger">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="flex flex-col text-[13px]"><?php echo validation_errors('<span>', '</span>'); ?></div>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <?php echo form_open('auth/register', ['class' => 'space-y-4']); ?>
                
                <!-- Username -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <input type="text" name="username" placeholder="Username" 
                           value="<?php echo set_value('username'); ?>"
                           class="input-field w-full py-4 pl-12 pr-4 rounded-2xl text-white placeholder-slate-500 text-sm" required>
                </div>

                <!-- Email -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <input type="email" name="email" placeholder="Email Address" 
                           value="<?php echo set_value('email'); ?>"
                           class="input-field w-full py-4 pl-12 pr-4 rounded-2xl text-white placeholder-slate-500 text-sm" required>
                </div>

                <!-- Password -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <input id="pass1" type="password" name="password" placeholder="Create Password" 
                           class="input-field w-full py-4 pl-12 pr-12 rounded-2xl text-white placeholder-slate-500 text-sm" required>
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <input id="pass2" type="password" name="confirm_password" placeholder="Confirm Password" 
                           class="input-field w-full py-4 pl-12 pr-12 rounded-2xl text-white placeholder-slate-500 text-sm" required>
                    
                    <!-- Fixed Toggle Button -->
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                        <button type="button" onclick="togglePass()" class="password-toggle bg-white rounded-full p-1.5 shadow-lg flex items-center justify-center">
                            <svg id="toggleIcon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-gradient w-full py-4 rounded-2xl text-white font-bold text-sm mt-4 flex items-center justify-center gap-2 group">
                    Sign Up
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform group-hover:translate-x-1"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                </button>
            <?php echo form_close(); ?>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-white/5">
                <p class="text-center text-xs text-slate-400">
                    Already have an account? 
                    <a href="<?php echo base_url('login'); ?>" class="text-indigo-400 hover:text-indigo-300 font-semibold ml-1">Sign in</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePass() {
            const p1 = document.getElementById("pass1");
            const p2 = document.getElementById("pass2");
            const toggleIcon = document.getElementById("toggleIcon");
            
            const type = p1.type === "password" ? "text" : "password";
            p1.type = type;
            p2.type = type;

            if (type === 'text') {
                // Show "unlocked" state
                toggleIcon.innerHTML = `
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
                `;
            } else {
                // Show "locked" state
                toggleIcon.innerHTML = `
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                `;
            }
        }
    </script>
</body>
</html>
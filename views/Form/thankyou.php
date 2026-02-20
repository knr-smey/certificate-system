<link rel="stylesheet" href="assets/css/class-free-form.css">

<div class="form-container thankyou-container">
    <div class="thankyou-content">
        <div class="thankyou-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
        </div>
        
        <h2 class="fade-in-text">សូមអរគុណចំពោះការដាក់ស្នើ!</h2>
        <p class="thankyou-message fade-in-text">អ្នកបានដាក់ស្នើរសុំសញ្ញាប័ត្ររបស់អ្នកដោយជោគជ័យ។ <br>
           សញ្ញាប័ត្រនឹងផ្ញើទៅកាន់អ្នកក្នុងពេលឆាប់ៗ។</p>
        
  

    </div>
</div>

<style>
/* Container & content */
.thankyou-container {
    text-align: center;
    background: linear-gradient(135deg, #e0f7fa 0%, #fff 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.thankyou-content {
    max-width: 500px;
    background: #fff;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    animation: slideUp 0.8s ease forwards;
}

/* Icon */
.thankyou-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 12px 24px rgba(34,197,94,0.3);
    animation: popBounce 0.8s ease forwards;
}

.thankyou-icon svg {
    width: 50px;
    height: 50px;
    color: white;
}

/* Headings and text */
h2 {
    color: #1f2442;
    font-size: 2rem;
    font-weight: 700;
    margin: 1rem 0;
}

.thankyou-message {
    color: #6d7393;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}

/* Other courses */
.other-courses-section {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e5e7f2;
}

.other-courses-section h3 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #1f2442;
}

.other-courses-section p {
    font-size: 0.9rem;
    color: #6d7393;
    margin-bottom: 1rem;
}

.course-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.course-item {
    background: white;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #1f2442;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    cursor: pointer;
}

.course-item:hover {
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

/* Back button */
.back-btn {
    display: inline-block;
    padding: 0.875rem 2rem;
    background: #2d2e81;
    color: #fff;
    border-radius: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: #232469;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(45,46,129,0.25);
}

/* Animations */
@keyframes popBounce {
    0% { transform: scale(0); }
    60% { transform: scale(1.2); }
    80% { transform: scale(0.95); }
    100% { transform: scale(1); }
}

@keyframes slideUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.fade-in-text {
    opacity: 0;
    animation: fadeIn 1s forwards;
    animation-delay: 0.5s;
}

.fade-in-text:nth-of-type(2) { animation-delay: 0.7s; }
.fade-in-text:nth-of-type(3) { animation-delay: 0.9s; }

@keyframes fadeIn {
    to { opacity: 1; }
}

/* Responsive */
@media (max-width: 576px) {
    .course-list { grid-template-columns: 1fr; }
    h2 { font-size: 1.5rem; }
    .thankyou-content { padding: 1.5rem; }
}
</style>
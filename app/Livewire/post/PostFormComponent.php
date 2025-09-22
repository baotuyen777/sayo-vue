<?php

namespace App\Livewire\post;

use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostFormComponent extends Component
{
    use WithFileUploads;

    public $code;
    public $obj = [];
    public $categories = [];
    public $provinces = [];
    public $districts = [];
    public $wards = [];
    public $extraAttributes = [];
    public $images = [];
    public $isEdit = false;
    public $fields = [];
    public $attrs = [];
    public $captchaQuestion = '';
    public $captchaAnswer = '';
    public $captchaResult = 0;

    protected $rules = [
        'obj.category_id' => 'required',
        'obj.name' => 'required|string',
        'obj.price' => 'required|numeric',
        'obj.content' => 'required|string',
        'obj.province_id' => 'required',
        'obj.district_id' => 'required',
        'obj.ward_id' => 'required',
        'obj.address' => 'required|string',
        'captchaAnswer' => 'required|numeric',
        // Add more rules as needed
    ];

    protected $messages = [
        'obj.category_id.required' => 'Vui lòng chọn danh mục',
        'obj.name.required' => 'Vui lòng nhập tiêu đề',
        'obj.price.required' => 'Vui lòng nhập giá',
        'obj.price.numeric' => 'Giá phải là số',
        'obj.content.required' => 'Vui lòng nhập mô tả',
        'obj.province_id.required' => 'Vui lòng chọn tỉnh/thành phố',
        'obj.district_id.required' => 'Vui lòng chọn quận/huyện',
        'obj.ward_id.required' => 'Vui lòng chọn xã/phường',
        'obj.address.required' => 'Vui lòng nhập địa chỉ chi tiết',
        'captchaAnswer.required' => 'Vui lòng nhập kết quả xác thực',
        'captchaAnswer.numeric' => 'Kết quả phải là số',
    ];

    public function mount($code = null)
    {
        $this->code = $code;
        $this->isEdit = !empty($code);
        $postService = new PostService();

        if ($this->isEdit) {
            $post = Post::getOne($code, true, true);
            if (!$post || (!isAuthor($post) && !isAdmin())) {
                abort(404);
            }
            $this->obj = $post->toArray();
            $options = $postService->getAttrOptions($post);
        } else {
            $user = Auth::user();
            $options = $postService->getAttrOptions($user);
            $obj = $postService->populateSellerAddress($user);
            $this->obj = $obj;
        }
        $this->categories = $options['categories'] ?? [];
        $this->provinces = $options['provinces'] ?? [];
        $this->districts = $options['districts'] ?? [];
        $this->wards = $options['wards'] ?? [];
        $this->fields = $options['fields'] ?? [];
        $this->attrs = $options['attrs'] ?? [];

        // Generate initial captcha
        $this->generateCaptcha();
    }

    public function generateCaptcha()
    {
        $num1 = rand(1, 20);
        $num2 = rand(1, 20);
        $operators = ['+', '-', '×'];
        $operator = $operators[array_rand($operators)];

        switch ($operator) {
            case '+':
                $this->captchaResult = $num1 + $num2;
                break;
            case '-':
                $this->captchaResult = $num1 - $num2;
                break;
            case '×':
                $this->captchaResult = $num1 * $num2;
                break;
        }

        $this->captchaQuestion = "{$num1} {$operator} {$num2} = ?";
        $this->captchaAnswer = '';
    }

    public function refreshCaptcha()
    {
        $this->generateCaptcha();
    }
    
    public function testMethod()
    {
        $this->dispatch('test-called', message: 'Test method called successfully!');
        Log::info('Test method called');
    }

    public function save()
    {
        // Debug: Dispatch event to frontend
        $this->dispatch('save-called');
        
        // Debug: Log the form data before validation
        Log::info('Form data before validation:', $this->obj);
        
        // Debug: Check if required fields are present
        $requiredFields = ['category_id', 'name', 'price', 'content', 'province_id', 'district_id', 'ward_id', 'address'];
        foreach ($requiredFields as $field) {
            Log::info("Field {$field}: " . ($this->obj[$field] ?? 'NOT SET'));
        }
        
        $this->validate();
        // Debug: Log that validation passed
        Log::info('Validation passed successfully');
        
        // Validate simple captcha
        if ($this->captchaAnswer != $this->captchaResult) {
            $this->addError('captchaAnswer', 'Kết quả xác thực không đúng. Vui lòng thử lại.');
            $this->generateCaptcha(); // Generate new captcha on failure
            return;
        }
        // Handle create or update logic
        $postService = new PostService();
        $postService->store($this->obj);

        // Generate new captcha after successful validation
        $this->generateCaptcha();

        // Flash success message and redirect to post list
        session()->flash('notify', 'Đăng tin thành công!');
        session()->flash('notify_type', 'success');
        return redirect()->route('archive');
        // Ensure method returns a value for Livewire
        return null;
    }

    public function render()
    {
        return view('livewire.post.post-form');
    }
}

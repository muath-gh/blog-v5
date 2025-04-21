---
Image: https://muath.algharabli.com/imgs/blog/posts/laravel-services/laravel-services.png
Title: "أفضل طريقة لتنظيم الأكواد في Laravel باستخدام Service Classes"
Description: "مقال شامل يوضح كيف تساعدك Service Classes في Laravel على تنظيم الأكواد، تبسيط المنطق البرمجي، وتحقيق مبدأ Single Responsibility عبر أمثلة حقيقية." 
Published at: 2025-04-21
Categories: laravel, clean-code, architecture
---

## مقدمة

في مشاريع Laravel الكبيرة أو المتوسطة، يزداد تعقيد الكود داخل الـ Controllers، مما يؤدي إلى صعوبة القراءة والصيانة والاختبار.  
من هنا تظهر أهمية استخدام **Service Classes** كطريقة فعالة لتنظيم الأكواد وفصل المهام.

في هذه المقالة، سنشرح مفهوم Service Classes، متى تستخدمها، وكيف تبنيها بطريقة احترافية، مدعومة بأمثلة حقيقية وأفضل الممارسات.

---

## ما هي Service Class؟

هي كلاس مخصصة تحتوي على منطق أعمال (Business Logic) محدد، تُستخدم من قِبل الـ Controllers أو الـ Jobs أو غيرها.

### ✅ الهدف منها:
- تقليل الكود داخل الـ Controllers.
- تطبيق مبدأ المسؤولية الواحدة (Single Responsibility Principle).
- تسهيل الاختبار والتعديل.

---

## متى تستخدم Service Classes؟

| الحالة | هل نستخدم Service؟ |
|--------|----------------------|
| الكود يتجاوز 30-40 سطر داخل controller | نعم |
| هناك أكثر من عملية متكررة على نفس النموذج | نعم |
| الكود بسيط ولا يتكرر | لا |

---

## كيف تنشئ Service Class في Laravel؟

### 1. إنشاء مجلد Services داخل `app/`
```bash
mkdir app/Services
```

### 2. إنشاء الكلاس
<div dir="ltr">

```php
namespace App\Services;

use App\Models\User;

class UserService
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }
}
```
</div>

---

## استخدام Service داخل Controller

<div dir="ltr">

```php
use App\Services\UserService;

class UserController extends Controller
{
    public function store(Request $request, UserService $userService)
    {
        $user = $userService->create($request->validated());
        return redirect()->route('users.index');
    }
}
```
</div>

---

## ماذا لو احتاجت الـ Service إلى Dependency؟

Laravel يدعم الـ Dependency Injection داخل Service Class مثل أي Controller.

<div dir="ltr">

```php
class OrderService
{
    public function __construct(protected PaymentGateway $gateway)
    {
    }

    public function process($order)
    {
        return $this->gateway->charge($order->amount);
    }
}
```
</div>

---

## استخدام الـ Service داخل Job

<div dir="ltr">

```php
class ProcessOrderJob implements ShouldQueue
{
    public function __construct(protected Order $order) {}

    public function handle(OrderService $orderService)
    {
        $orderService->process($this->order);
    }
}
```
</div>

---

## مقارنة قبل وبعد استخدام Service

### ❌ قبل (في Controller)

<div dir="ltr">

```php
public function store(Request $request)
{
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    Mail::to($user->email)->send(new WelcomeMail($user));
}
```
</div>

### ✅ بعد (مع Service)

<div dir="ltr">

```php
public function store(Request $request, UserService $userService)
{
    $userService->register($request->validated());
}
```
</div>

داخل الـ Service:

<div dir="ltr">

```php
public function register(array $data)
{
    $user = User::create($data);
    Mail::to($user->email)->send(new WelcomeMail($user));
}
```
</div>

---

## Service vs Trait vs Helper

| الأسلوب | متى نستخدمه؟ |
|---------|---------------|
| Service | منطق أعمال كبير أو متكرر |
| Trait | مشاركة وظائف بسيطة داخل أكثر من كلاس |
| Helper | دوال بسيطة أو ثابتة الاستخدام |

---

## نصائح عامة

1. اجعل كل Service متخصصة بمهمة واحدة فقط.
2. لا تربط الـ Service مباشرة بالـ Controller فقط، استخدمها في Jobs وCommands أيضًا.
3. اسم الكلاس يجب أن يعكس وظيفته: `InvoiceService`, `PaymentService`.

---

## الخلاصة

Service Classes في Laravel هي أداة قوية لتنظيم الكود ورفع جودة المشروع.  
تساعدك في كتابة كود نظيف، قابل للصيانة، وقابل للاختبار بسهولة.

هل تستخدم Service Classes في مشاريعك؟ شاركنا تجربتك!

---

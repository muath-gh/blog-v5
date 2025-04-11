---
Image: https://muath.algharabli.com/imgs/blog/posts/webhook/webhook.png
Title: "ما هو Webhook؟ وما الفرق بينه وبين API؟"
Description: "مقال مبسّط يشرح مفهوم الـ Webhook، الفرق بينه وبين الـ API، وكيف تختار الأداة الأنسب للتكامل بين الأنظمة البرمجية."
Published at: 2025-04-11
Categories: integration, backend, webhooks
---

## مقدمة

مع تطوّر الأنظمة وتكامل الخدمات الرقمية، أصبح من الضروري فهم الفرق بين الأدوات التي تتيح للتطبيقات التفاعل مع بعضها البعض.  
من أبرز هذه الأدوات هما: **الـ API** و **الـ Webhook**.  
في هذا المقال، رح نغوص بتفصيل سهل وواضح في تعريف كل واحدة، الفرق بينهم، ومتى تستخدم كل واحدة.

---

## ما هو الـ API؟

الـ API (Application Programming Interface) هو واجهة تسمح لتطبيقين أو نظامين بالتواصل عبر إرسال واستقبال طلبات.

🔹 ببساطة: هو مثل بوابة بيقدر تطبيق A يطلب من تطبيق B بيانات أو ينفّذ وظيفة.

مثال عملي: تطبيق الطقس على موبايلك يرسل طلب (request) لسيرفر خارجي، وبيرجع له الرد (response) بدرجة الحرارة.

<div dir="ltr">

```http
GET https://api.weather.com/v1/location/amman?units=metric
```

</div>

🔁 الـ API بيشتغل بنظام **الطلب والاستجابة** (Request/Response)، والبيانات غالبًا تُنقل بصيغة JSON أو XML.

---

## ما هو الـ Webhook؟

الـ Webhook هو طريقة لنقل البيانات **عند حدوث حدث معيّن (Event)** بدون الحاجة لإرسال طلب.

🔹 الفرق الجوهري: الـ Webhook يشتغل **بشكل تلقائي**، مش بطلب منك.

مثال: لما عميل يدفع على Stripe، الـ Webhook بيبعتلك إشعار تلقائي بتفاصيل الدفع.

<div dir="ltr">

```json
{
  "event": "payment_success",
  "amount": "50.00",
  "currency": "USD",
  "customer_email": "test@example.com"
}
```

</div>

🔸 وهون الفرق: مش تطبيقك اللي طلب، بل Stripe اللي بادر وأرسل البيانات.

---

## مقارنة بين الـ API والـ Webhook

| الجانب | API | Webhook |
|--------|-----|---------|
| طريقة العمل | طلب واستجابة | إرسال تلقائي عند حدث |
| الاتجاه | ثنائي (two-way) | أحادي (one-way) |
| الأداء | يحتاج استعلام متكرر | فوري وفعّال |
| المرونة | عالي | محدود |
| الاستخدام المثالي | استرجاع أو تعديل البيانات | إشعارات فورية (real-time events) |

---

## حالات الاستخدام

### ✅ متى تستخدم الـ API؟
- بدك تتحكم بالبيانات (تعديل – حذف – قراءة).
- تحتاج إلى بيانات متنوعة من نقاط مختلفة (Endpoints).
- لازم التطبيق يستعلم بشكل متكرر.

### ✅ متى تستخدم الـ Webhook؟
- لما تحتاج إشعارات مباشرة عند حدوث حدث.
- تريد تقليل عدد الاستعلامات (Requests).
- مش محتاج تحكم أو تعديل على الطرف الثاني.

---

## كيف تنشئ Webhook؟

رح نستخدم مثال باستخدام **PHP Laravel** لتوضيح طريقة استقبال الـ Webhook.

### 1. جهّز الـ Route:
<div dir="ltr">

```php
// Laravel route example
Route::post('/webhook/stripe', [StripeWebhookController::class, 'handle']);
```

</div>

### 2. أنشئ Controller يستقبل البيانات:
<div dir="ltr">

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        // مثال على معالجة البيانات
        if ($payload['event'] === 'payment_success') {
            \Log::info("تم الدفع بنجاح للعميل: " . $payload['customer_email']);
        }

        return response()->json(['status' => 'received']);
    }
}
```

</div>

---

## الخلاصة

كل من الـ API و الـ Webhook إله دوره الخاص. الـ API قوي وشامل، بينما الـ Webhook بسيط وسريع.  
الذكاء مش باختيار الأداة الأقوى، بل **باختيار الأداة الأنسب للموقف**.

هل واجهت موقف استخدمت فيه Webhook أو API؟ شاركنا تجربتك!

---
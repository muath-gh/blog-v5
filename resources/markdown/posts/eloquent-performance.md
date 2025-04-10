---
Image: https://muath.algharabli.com/imgs/blog/posts/el-performance/el-performance.png
Title: "تحسين أداء Laravel Eloquent"
Description: "دليل شامل لتحسين أداء Eloquent في Laravel، نشرح فيه مشاكل مثل lazy loading و N+1، ونستعرض طرق الحل مثل eager loading وميزات Laravel 12 الحديثة."
Published at: 2025-04-10
Categories: laravel, performance, backend
---

## مقدمة

عند استخدام Laravel Eloquent في الprojects الكبيرة، من السهل الوقوع في مشاكل تؤثر على الأداء مثل **Lazy Loading** أو **N+1 Problem**.  
هذه المقالة موجّهة للمطورين الذين يرغبون في فهم أسباب هذه المشاكل وكيفية تجنّبها، بالإضافة إلى استعراض ميزات حديثة مثل `withRelationshipAutoloading`، وتسليط الضوء على استخدامات مفيدة مثل `whenLoaded`.

---

## ما هو Lazy Loading؟

هو الأسلوب الافتراضي في Eloquent لloading relationships، حيث لا يتم loading الrelationship مع الquery الأساسي، بل يتم استدعاؤها فقط عند access لها.

<div dir="ltr">

```php
$post = Post::first();
echo $post->user->name; // query إضافي عند access للrelationship
```
</div>

### ❌ سلبياته:
- يؤدي إلى تنفيذ عدد كبير من الqueryات عند تكرار access للعلاقات.
- يؤدي إلى **N+1 Problem**.

---

## مشكلة N+1

تحدث عندما تقوم بloading مجموعة من الrecords، وتصل إلى relationship في كل سجل بشكل منفصل.

<div dir="ltr">

```php
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->user->name;
}
```
</div>

إذا كان هناك 100 منشور، سيتم تنفيذ **101 query** (واحد لجلب المنشورات و100 لجلب المستخدمين).

---

## الحل: Eager Loading

يسمح لك `Eager Loading` بloading relationships مع الquery الأساسي، لتقليل عدد الqueryات.

<div dir="ltr">

```php
$posts = Post::with('user')->get();
```
</div>

هذا يؤدي إلى تنفيذ **queryين فقط** بغض النظر عن عدد المنشورات.

### ✅ دعم relationships المتعددة:
<div dir="ltr">

```php
$posts = Post::with(['user', 'comments'])->get();
```
</div>

---

## متى تستخدم Lazy ومتى تستخدم Eager؟

| الحالة | التوصية |
|--------|----------|
| عدد الrecords قليل جدًا | Lazy Loading مقبول |
| access المتكرر للعلاقات | استخدم Eager Loading |
| في الـ API أو pages تحتوي عناصر كثيرة | Eager أفضل بكثير |

---

## feature Laravel 12: withRelationshipAutoloading

في Laravel 12، تم تقديم `withRelationshipAutoloading()` لتفعيل `eager loading` تلقائيًا عند access للعلاقات.

<div dir="ltr">

```php
User::withRelationshipAutoloading();
```
</div>

### ✅ طريقة العمل:
بمجرد استدعاء هذا method، سيتم مراقبة relationships عند access لها، وإذا لم تكن محملة سيتم loadingها تلقائيًا بكفاءة.

### ⚠️ ملاحظات:
- لا تغني عن التخطيط المسبق للعلاقات.
- مفيدة في الـ APIs أو الprojects الكبيرة.

[المصدر الرسمي (Laravel 12 Docs)](https://laravel.com/docs/12.x/eloquent-relationships#preventing-n-plus-one)

---

## استخدام whenLoaded

يساعدك `whenLoaded` في كتابة كود نظيف يتأكد من أن الrelationship تم loadingها قبل استخدامها.

<div dir="ltr">

```php
return [
    'name' => $user->name,
    'posts' => $user->posts->whenLoaded('posts'),
];
```
</div>

### ✅ الفائدة:
- يمنع الوقوع في خطأ access لعلاقات غير محملة.
- يحسّن الأداء عند بناء الموارد (Resources).

---

## نصائح إضافية لتحسين أداء Eloquent

### 1. استخدام select() لتحديد الأعمدة المطلوبة فقط
عند استخدام Eloquent بدون تحديد الأعمدة، يتم جلب جميع الأعمدة من الجدول بشكل افتراضي، حتى لو لم تكن بحاجة إليها.  
هذا يؤدي إلى تحميل غير ضروري للبيانات واستهلاك أعلى للذاكرة والأداء.

<div dir="ltr">

```php
$users = User::select('name', 'email')->get();
```
</div>

**الفوائد:**
- **أداء أفضل**: تقليل حجم البيانات المنقولة من قاعدة البيانات.
- **أمان أعلى**: تجنب تسريب بيانات حساسة مثل `password` أو `is_admin`.
- **تحكم أكبر**: تعرف بالضبط ما الذي يتم جلبه من قاعدة البيانات.

### 2. تقليل عدد الresults عبر `paginate()` أو `chunk()`
<div dir="ltr">

```php
User::paginate(20);
```
</div>

### 3. فلترة relationships باستخدام `with()`
<div dir="ltr">

```php
User::with(['posts' => function ($query) {
    $query->where('published', true);
}])->get();
```
</div>

### 4. الاستفادة من الـ Indexes في قاعدة البيانات



⚠️ يفضل دائمًا استخدام `select()` في استعلامات الـ API أو عند التعامل مع جداول تحتوي على أعمدة كثيرة أو بيانات ثقيلة.


احرص على وجود Index على الحقول التي تُستخدم بكثرة في شروط `WHERE` و `JOIN`.

---


## خلاصة

تحسين أداء Eloquent ليس فقط عن طريق كتابة كود "يعمل"، بل كود يعمل بكفاءة.  
فهم الفرق بين Lazy و Eager Loading، وكيفية تجنّب N+1، واستخدام ميزات Laravel الحديثة مثل `withRelationshipAutoloading` يمكن أن يُحدث فارقًا كبيرًا في أداء تطبيقك.

هل تستخدم Lazy أم Eager في projectsك؟ وهل جرّبت feature Laravel 12 الجديدة؟ شاركنا رأيك!

---

---
Image: https://muath.algharabli.com/imgs/blog/posts/laravel12-orm/laravel12-orm.png
Title: "3 مزايا جديدة في Laravel 12 لتسهيل التعامل مع Eloquent ORM"
Description: "نتعرّف في هذا المقال على 3 ميزات رائعة تم تقديمها في Laravel 12 لتسهيل التعامل مع العلاقات، التحميل الكسول، والإدخال الجماعي للبيانات داخل Eloquent ORM."
Published at: 2025-04-16
Categories: laravel, eloquent, php
---

## مقدمة

في كل إصدار جديد من Laravel، يتم تقديم تحسينات تجعل التعامل مع البيانات أكثر سهولة ومرونة. وفي Laravel 12، تم إدخال ثلاث ميزات مذهلة تسهّل استخدام Eloquent ORM في سيناريوهات حقيقية مثل العلاقات المعقّدة، الأداء العالي، والإدخال السريع للبيانات.

في هذا المقال، سنتناول ثلاث ميزات رئيسية:
- `whereAttachedTo`
- `withRelationshipAutoloading`
- `fillAndInsert`

مع شرح تفصيلي لكل ميزة وأمثلة عملية توضّح مدى فائدتها.

---

## نبذة عن Laravel 12 وEloquent ORM

من أبرز ما جاء في Laravel 12 هو تعزيز واجهات التعامل مع Eloquent ORM، خصوصًا فيما يتعلق بالعلاقات (Relationships) وإدارة البيانات بكفاءة. سنتناول هنا مثالًا تقليديًا لعلاقة **Many-to-Many** بين نموذج `Post` ونموذج `Tag`.

---

## مثال على علاقة Many-to-Many (Post ↔ Tags)

### نموذج `Post`
<div dir="ltr">

```php
class Post extends Model {
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
```
</div>

### نموذج `Tag`
<div dir="ltr">

```php
class Tag extends Model {
    public function posts() {
        return $this->belongsToMany(Post::class);
    }
}
```
</div>

---

## 1️⃣ الطريقة القديمة لجلب بوستات مرتبطة بتاغات خلال 3 شهور ماضية
<div dir="ltr">

```php
$tags = Tag::where('created_at', '>', now()->subMonths(3))->get();

$posts = Post::whereHas('tags', function($query) use ($tags) {
    $query->whereIn('id', $tags->pluck('id'));
})->get();
```
</div>

---

## 2️⃣ الطريقة الجديدة باستخدام `whereAttachedTo`
<div dir="ltr">

```php
$tags = Tag::where('created_at', '>', now()->subMonths(3))->get();

$posts = Post::whereAttachedTo($tags)->get();
```
</div>

### كيف تعمل `whereAttachedTo`؟

هذه الميثود الجديدة تمكّنك من جلب السجلات المرتبطة بعلاقات `belongsToMany` و `morphToMany` بدون الحاجة لتحديد العلاقة صراحة. ومع ذلك، يمكنك تحديد العلاقة كوسيط ثانٍ:
<div dir="ltr">

```php
Post::whereAttachedTo($tags, 'tags')->get();
```
</div>
الميثود أيضًا تدعم العلاقات المتعددة والمركّبة (deep relationships).

---

## 3️⃣ `withRelationshipAutoloading` لحل مشكلة Lazy Loading

### مثال على Lazy Loading يسبب N+1 Problem:
<div dir="ltr">

```blade
<table>
@foreach($posts as $post)
    <tr>
        <td>{{ $post->title }}</td>
        <td>{{ $post->user->name }}</td> <!-- هنا يتم استدعاء query لكل صف -->
    </tr>
@endforeach
</table>
```
</div>

### الحل: Eager Loading
<div dir="ltr">

```php
$posts = Post::with('user')->get();
```
</div>

---

## 4️⃣ الميزة الجديدة: `withRelationshipAutoloading`

### تفعيل التحميل المسبق تلقائيًا لموديل معين:
<div dir="ltr">

```php
Post::withRelationshipAutoloading();
$posts = Post::all(); // سيتم تحميل علاقة user تلقائيًا لو تم استخدامها
```
</div>

### تفعيل الميزة لجميع الموديلات في `AppServiceProvider`:
<div dir="ltr">

```php
use Illuminate\Database\Eloquent\Model;

public function boot(): void {
    Model::preventLazyLoading();
    Model::withRelationshipAutoloading();
}
```
</div>

---

## 5️⃣ التعامل مع الإدخال الجماعي للبيانات (Bulk Insert)

### المشكلة:
<div dir="ltr">

```php
User::insert([
    ['name' => 'Muath', 'email' => 'muath@example.com', 'password' => bcrypt('123')],
    ['name' => 'Hussam', 'email' => 'hussam@example.com', 'password' => bcrypt('123')],
]);
```
</div>

الميثود `insert` لا تقوم بتفعيل `mutators` مثل `setPasswordAttribute`، ولا تضيف `created_at` و `updated_at` تلقائيًا.

### مثال على mutator يتم تجاهله عند استخدام insert:
<div dir="ltr">

```php
public function setNameAttribute($value)
{
    $this->attributes['name'] = strtoupper($value);
}
```
</div>

---

## 6️⃣ الحل: `fillAndInsert`

### مثال:
<div dir="ltr">

```php
User::fillAndInsert([
    ['name' => 'Muath', 'email' => 'muath@example.com', 'password' => '123'],
    ['name' => 'Hussam', 'email' => 'hussam@example.com', 'password' => '123'],
]);
```
</div>

سيتم:
- تفعيل `mutators` مثل `password` hashing و `name` إلى uppercase.
- تعبئة الحقول التلقائية مثل `created_at`.

---

## الخاتمة

تستمر Laravel في تقديم أدوات قوية تسهّل حياة المطورين، وتزيد من كفاءة كتابة الكود اليومي. سواء كنت تعمل على مشروع صغير أو نظام كبير، الميزات الجديدة مثل `whereAttachedTo`, `withRelationshipAutoloading`، و`fillAndInsert` تتيح لك كتابة كود أنظف، أسرع، وأسهل في الصيانة.

هل جرّبت أي من هذه الميزات؟ شاركنا تجربتك في التعليقات!

---

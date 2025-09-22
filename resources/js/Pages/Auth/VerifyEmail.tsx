import PrimaryButton from '@/Components/Core/PrimaryButton';
import GuestLayout from '@/Layouts/GuestLayout';
import {Head, Link, useForm} from '@inertiajs/react';
import {FormEventHandler} from 'react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function VerifyEmail({status}: { status?: string }) {
  const {post, processing} = useForm({});

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route('verification.send'));
  };

  return (
    <AuthenticatedLayout>
      <Head title="Email Verification"/>
      <div className={"p-8"}>
        <div className="card bg-white dark:bg-gray-800 shadow max-w-[420px] mx-auto">
          <div className="card-body">
            <div className="mb-4 text-sm text-gray-600 dark:text-gray-400">
              شكراً على التسجيل! قبل البدء، هل يمكنك التحقق من عنوان بريدك الإلكتروني بالنقر على الرابط الذي أرسلناه إليك للتو عبر البريد الإلكتروني؟ إذا لم تستلم البريد الإلكتروني، فسوف نرسل إليك بريداً آخر.
            </div>

            {status === 'verification-link-sent' && (
              <div className="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                تم إرسال رابط تحقق جديد إلى عنوان البريد الإلكتروني الذي قدمته أثناء التسجيل.
              </div>
            )}

            <form onSubmit={submit}>
              <div className="mt-4 flex items-center justify-between">
                <PrimaryButton disabled={processing}>
                  إعادة إرسال رسالة التحقق عبر البريد الإلكتروني
                </PrimaryButton>

                <Link
                  href={route('logout')}
                  method="post"
                  as="button"
                  className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                >
                  تسجيل الخروج
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>

    </AuthenticatedLayout>
  );
}

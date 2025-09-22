import InputError from '@/Components/Core/InputError';
import PrimaryButton from '@/Components/Core/PrimaryButton';
import TextInput from '@/Components/Core/TextInput';
import {Head, useForm} from '@inertiajs/react';
import {FormEventHandler} from 'react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function ForgotPassword({status}: { status?: string }) {
  const {data, setData, post, processing, errors} = useForm({
    email: '',
  });

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route('password.email'));
  };

  return (
    <AuthenticatedLayout>
      <Head title="Register"/>
      <div className={"p-8"}>
        <div className="card bg-white dark:bg-gray-800 shadow max-w-[420px] mx-auto">
          <div className="card-body">

            <h1 className={"text-2xl mb-6 text-center"}>نسيت كلمة المرور</h1>

            <div className="mb-4 text-sm text-gray-800 dark:text-neutral-content">
              هل نسيت كلمة المرور؟ 
              لا تقلق. فقط أخبرنا بعنوان بريدك الإلكتروني 
              وسنرسل لك رابطًا لإعادة تعيين كلمة المرور 
              عبر البريد الإلكتروني، مما سيسمح لك باختيار كلمة مرور جديدة.
            </div>

            {status && (
              <div className="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                {status}
              </div>
            )}

            <form onSubmit={submit}>
              <TextInput
                id="email"
                type="email"
                name="email"
                value={data.email}
                className="mt-1 block w-full"
                isFocused={true}
                placeholder={"بريدك الإلكتروني"}
                onChange={(e) => setData('email', e.target.value)}
              />

              <InputError message={errors.email} className="mt-2"/>

              <div className="mt-4 flex items-center justify-end">
                <PrimaryButton className="ms-4" disabled={processing}>
                  رابط إعادة تعيين كلمة مرور البريد الإلكتروني
                </PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}

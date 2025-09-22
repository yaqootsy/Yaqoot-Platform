import DangerButton from '@/Components/Core/DangerButton';
import InputError from '@/Components/Core/InputError';
import InputLabel from '@/Components/Core/InputLabel';
import Modal from '@/Components/Core/Modal';
import SecondaryButton from '@/Components/Core/SecondaryButton';
import TextInput from '@/Components/Core/TextInput';
import { useForm } from '@inertiajs/react';
import { FormEventHandler, useRef, useState } from 'react';

export default function DeleteUserForm({
    className = '',
}: {
    className?: string;
}) {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const passwordInput = useRef<HTMLInputElement>(null);

    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        errors,
        clearErrors,
    } = useForm({
        password: '',
    });

    const confirmUserDeletion = () => {
        setConfirmingUserDeletion(true);
    };

    const deleteUser: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current?.focus(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);

        clearErrors();
        reset();
    };

    return (
        <section className={`space-y-6 ${className}`}>
            <header>
                <h2 className="text-lg font-medium text-red-500 dark:text-red-100">
                    <b>منطقة خطرة: حذف الحساب</b>
                </h2>

                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته
                    بشكل دائم. قبل حذف حسابك،
                    يرجى تنزيل أي بيانات أو معلومات ترغب في
                    الاحتفاظ بها.
                </p>
            </header>

            <DangerButton onClick={confirmUserDeletion}>
                حذف الحساب
            </DangerButton>

            <Modal show={confirmingUserDeletion} onClose={closeModal}>
                <form onSubmit={deleteUser} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                        هل أنت متأكد من أنك تريد حذف حسابك؟
                    </h2>

                    <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته
                        بشكل دائم. يرجى إدخال كلمة المرور الخاصة بك
                        لتأكيد رغبتك في حذف حسابك بشكل دائم.
                        حذف حسابك
                    </p>

                    <div className="mt-6">
                        <InputLabel
                            htmlFor="password"
                            value="كلمة المرور"
                            className="sr-only"
                        />

                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            ref={passwordInput}
                            value={data.password}
                            onChange={(e) =>
                                setData('password', e.target.value)
                            }
                            className="mt-1 block w-3/4"
                            isFocused
                            placeholder="كلمة المرور"
                        />

                        <InputError
                            message={errors.password}
                            className="mt-2"
                        />
                    </div>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeModal}>
                            إلغاء
                        </SecondaryButton>

                        <DangerButton className="ms-3" disabled={processing}>
                            حذف الحساب
                        </DangerButton>
                    </div>
                </form>
            </Modal>
        </section>
    );
}

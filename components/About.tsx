'use client'

import { motion } from 'framer-motion'
import { CheckCircle, Star, Shield, Zap } from 'lucide-react'

const features = [
  {
    icon: CheckCircle,
    title: 'Competence',
    description: 'We have the expertise to constitutionally challenge ultra vires exercises of power and obtain restraining orders from courts.'
  },
  {
    icon: Star,
    title: 'One-Window Operation',
    description: 'Complete tax consultancy covering income tax, sales tax, customs, provincial taxes, and international taxation.'
  },
  {
    icon: Shield,
    title: 'Experience',
    description: 'Skilled team with capacity to contest cases at original and appellate forums up to High Court and Supreme Court.'
  },
  {
    icon: Zap,
    title: 'Speed & Precision',
    description: 'Known for swift response and effective solutions to complex legal issues with proven results.'
  }
]

export default function About() {
  return (
    <section className="section-padding bg-gray-50">
      <div className="container-custom">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
          >
            <h2 className="text-4xl md:text-5xl font-bold mb-6">
              Why Choose <span className="gradient-text">eTax consultants</span>
            </h2>
            
            <p className="text-lg text-gray-600 mb-8 leading-relaxed">
              eTax consultants has been at the forefront of tax consultancy in Pakistan for over two decades. 
              Our team combines deep legal expertise with practical business understanding to deliver 
              exceptional results for our clients.
            </p>
            
            <p className="text-lg text-gray-600 mb-8 leading-relaxed">
              We believe in providing not just legal representation, but strategic partnership that 
              helps our clients navigate the complex Pakistani tax landscape with confidence and success.
            </p>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
              {features.map((feature, index) => (
                <motion.div
                  key={feature.title}
                  className="flex items-start gap-3"
                  initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.6, delay: index * 0.1 }}
                >
                  <div className="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <feature.icon className="w-4 h-4 text-primary-600" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 mb-1">{feature.title}</h4>
                    <p className="text-sm text-gray-600 leading-relaxed">{feature.description}</p>
                  </div>
                </motion.div>
              ))}
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 20 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8, delay: 0.2 }}
            className="relative"
          >
            <div className="bg-white rounded-2xl p-8 shadow-xl">
              <div className="text-center mb-6">
                <h3 className="text-2xl font-bold text-gray-900 mb-2">Client Testimonial</h3>
                <div className="flex justify-center mb-4">
                  {[...Array(5)].map((_, i) => (
                    <Star key={i} className="w-5 h-5 text-accent-500 fill-current" />
                  ))}
                </div>
              </div>
              
              <blockquote className="text-gray-600 italic mb-6 leading-relaxed">
                "eTax consultants always offers effective solutions to complex legal issues. Their forte is their 
                speed and swift response. We believe that they are the finest lawyers a litigant can find 
                in our legal system."
              </blockquote>
              
              <div className="text-center">
                <div className="font-semibold text-gray-900">Zaheer Allana</div>
                <div className="text-sm text-gray-500">Bin Qasim (Pvt) Ltd.</div>
              </div>
            </div>
            
            {/* Decorative elements */}
            <div className="absolute -top-4 -right-4 w-20 h-20 bg-primary-200 rounded-full opacity-20"></div>
            <div className="absolute -bottom-4 -left-4 w-16 h-16 bg-accent-200 rounded-full opacity-20"></div>
          </motion.div>
        </div>
      </div>
    </section>
  )
}
